<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Weight;
use App\DataTables\Admin\WeightsDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WeightController extends Controller
{
    public function index(WeightsDataTable $dataTable)
    {
        return $dataTable->render('admin.pages.weights.index');
    }

    public function show(string $id)
    {
        $weight = Weight::with('user')->findOrFail($id);
        return view('admin.pages.weights.show', compact('weight'));
    }

    public function edit(string $id)
    {
        $weight = Weight::findOrFail($id);
        return view('admin.pages.weights.edit', compact('weight'));
    }

    public function update(Request $request, string $id)
    {
        $weight = Weight::findOrFail($id);
        $data = $request->validate([
            'weight' => 'required|numeric|min:0',
            'recorded_at' => 'required|date|before_or_equal:now',
            'notes' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|image|max:2048',
        ]);

        if ($request->hasFile('attachment')) {
            if ($weight->attachment_url) {
                $oldPath = str_replace('storage/', '', $weight->attachment_url);
                Storage::disk('public')->delete($oldPath);
            }

            $file = $request->file('attachment');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs($weight->user_id . '/weights', $fileName, 'public');
            $data['attachment_url'] = 'storage/' . $path;
        }

        $weight->update($data);

        flash()->success(__('message.weight.update_success'), [], __('notification.success'));
        return redirect()->route('admin.weights.index');
    }

    public function destroy(string $id)
    {
        $weight = Weight::findOrFail($id);

        if ($weight->attachment_url) {
            $oldPath = str_replace('storage/', '', $weight->attachment_url);
            Storage::disk('public')->delete($oldPath);
        }

        $weight->delete();

        flash()->success(__('message.weight.delete_success'), [], __('notification.success'));
        return redirect()->route('admin.weights.index');
    }
}
