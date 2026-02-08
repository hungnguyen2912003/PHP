<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Measurement;
use App\Models\User;
use App\DataTables\AdminMeasurementDataTable;
use App\DataTables\UserMeasurementsDataTable;
use App\Http\Requests\Admin\Measurement\UpdateMeasurementRequest;
use App\Http\Requests\Admin\users\ImportMeasurementRequest;
use App\Imports\MeasurementImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MeasurementController extends Controller
{
    public function index(AdminMeasurementDataTable $dataTable)
    {
        return $dataTable->render('admin.pages.measurements.index');
    }

    public function user(string $id)
    {
        $user = User::findOrFail($id);
        $dataTable = new UserMeasurementsDataTable($id);
        return $dataTable->render('admin.pages.measurements.user', compact('user'));
    }

    public function edit(string $id)
    {
        $measurement = Measurement::with('user')->findOrFail($id);
        return view('admin.pages.measurements.edit', compact('measurement'));
    }

    public function update(UpdateMeasurementRequest $request, string $id)
    {
        $measurement = Measurement::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($measurement->attachment_url) {
                $oldPath = str_replace('storage/', '', $measurement->attachment_url);
                Storage::disk('public')->delete($oldPath);
            }

            $file = $request->file('attachment');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs($measurement->user_id . '/measurements', $fileName, 'public');
            $data['attachment_url'] = 'storage/' . $path;
        } elseif ($request->input('remove_attachment') == '1') {
            if ($measurement->attachment_url) {
                $oldPath = str_replace('storage/', '', $measurement->attachment_url);
                Storage::disk('public')->delete($oldPath);
            }
            $data['attachment_url'] = null;
        }

        $measurement->update($data);

        flash()->success(__('message.measurement.update_success'), [], __('notification.success'));
        return redirect()->route('admin.measurements.index');
    }

    public function destroy(string $id)
    {
        $measurement = Measurement::findOrFail($id);

        if ($measurement->attachment_url) {
            $oldPath = str_replace('storage/', '', $measurement->attachment_url);
            Storage::disk('public')->delete($oldPath);
        }

        $measurement->delete();

        flash()->success(__('message.measurement.delete_success'), [], __('notification.success'));
        return redirect()->route('admin.measurements.index');
    }

    public function import(ImportMeasurementRequest $request, $id)
    {
        $user = User::findOrFail($id);

        try {
            Excel::import(new MeasurementImport($user->id), $request->file('file'));

            flash()->success(__('message.import.success'), [], __('notification.success'));
        } catch (\Throwable $e) {
            report($e);
            flash()->error(__('message.import.failed'), [], __('notification.error'));
        }

        return redirect()->back();
    }
}
