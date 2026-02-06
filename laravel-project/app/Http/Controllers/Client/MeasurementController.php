<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Measurement;
use App\DataTables\MeasurementDataTable;
use App\Http\Requests\Client\Measurement\StoreMeasurementRequest;
use App\Http\Requests\Client\Measurement\UpdateMeasurementRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MeasurementController extends Controller
{
    public function index(MeasurementDataTable $dataTable)
    {
        return $dataTable->render('client.pages.measurement.index');
    }

    public function create()
    {
        return view('client.pages.measurement.create');
    }

    public function store(StoreMeasurementRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs(auth()->id() . '/measurements', $fileName, 'public');
            $data['attachment_url'] = 'storage/' . $path;
        }

        // Use updateOrCreate based on user_id and recorded_at to avoid duplicates
        Measurement::updateOrCreate(
            [
                'user_id'     => $data['user_id'],
                'recorded_at' => $data['recorded_at'],
            ],
            $data
        );

        flash()->success(__('message.measurement.create_success'), [], __('notification.success'));
        return redirect()->route('client.measurement.index');
    }

    public function show(string $id)
    {
        $measurement = Measurement::findOrFail($id);
        return view('client.pages.measurement.show', compact('measurement'));
    }

    public function edit(string $id)
    {
        $measurement = Measurement::findOrFail($id);
        return view('client.pages.measurement.edit', compact('measurement'));
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
            $path = $file->storeAs(auth()->id() . '/measurements', $fileName, 'public');
            $data['attachment_url'] = 'storage/' . $path;
        } elseif ($request->input('remove_attachment') == '1') {
            if ($measurement->attachment_url) {
                $oldPath = str_replace('storage/', '', $measurement->attachment_url);
                Storage::disk('public')->delete($oldPath);
            }
            $data['attachment_url'] = null;
        }

        // Check for existing records for the same user and timestamp to consolidate
        $existingRecord = Measurement::where('user_id', auth()->id())
            ->where('recorded_at', $data['recorded_at'])
            ->where('id', '!=', $measurement->id)
            ->first();

        if ($existingRecord) {
            $existingRecord->update($data);
            $measurement->delete();
        } else {
            $measurement->update($data);
        }

        flash()->success(__('message.measurement.update_success'), [], __('notification.success'));
        return redirect()->route('client.measurement.index');
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
        return redirect()->route('client.measurement.index');
    }
}
