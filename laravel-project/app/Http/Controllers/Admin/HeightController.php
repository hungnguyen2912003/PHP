<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Height;
use App\DataTables\Admin\HeightsDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeightController extends Controller
{
    public function index(HeightsDataTable $dataTable)
    {
        return $dataTable->render('admin.pages.heights.index');
    }

    public function show(string $id)
    {
        $height = Height::with('user')->findOrFail($id);
        return view('admin.pages.heights.show', compact('height'));
    }

    public function edit(string $id)
    {
        $height = Height::findOrFail($id);
        return view('admin.pages.heights.edit', compact('height'));
    }

    public function update(Request $request, string $id)
    {
        $height = Height::findOrFail($id);
        $data = $request->validate([
            'height' => 'required|numeric|min:0',
            'recorded_at' => 'required|date|before_or_equal:now',
            'notes' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|image|max:2048',
        ]);

        if ($request->hasFile('attachment')) {
            if ($height->attachment_url) {
                $oldPath = str_replace('storage/', '', $height->attachment_url);
                Storage::disk('public')->delete($oldPath);
            }

            $file = $request->file('attachment');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs($height->user_id . '/heights', $fileName, 'public');
            $data['attachment_url'] = 'storage/' . $path;
        }

        $height->update($data);

        flash()->success(__('message.height.update_success'), [], __('notification.success'));
        return redirect()->route('admin.heights.index');
    }

    public function destroy(string $id)
    {
        $height = Height::findOrFail($id);

        if ($height->attachment_url) {
            $oldPath = str_replace('storage/', '', $height->attachment_url);
            Storage::disk('public')->delete($oldPath);
        }

        $height->delete();

        flash()->success(__('message.height.delete_success'), [], __('notification.success'));
        return redirect()->route('admin.heights.index');
    }
}
