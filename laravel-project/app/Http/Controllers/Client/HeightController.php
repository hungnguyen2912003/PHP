<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Height;
use App\DataTables\HeightDataTable;
use App\Http\Requests\Client\Height\StoreHeightRequest;
use App\Http\Requests\Client\Height\UpdateHeightRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(HeightDataTable $dataTable)
    {
        return $dataTable->render('client.pages.height.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('client.pages.height.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHeightRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs(auth()->id() . '/heights', $fileName, 'public');
            $data['attachment_url'] = 'storage/' . $path;
        }

        // Use updateOrCreate based on user_id and recorded_at
        Height::updateOrCreate(
            [
                'user_id'     => $data['user_id'],
                'recorded_at' => $data['recorded_at'],
            ],
            $data
        );

        flash()->success(__('message.height.create_success'), [], __('notification.success'));
        return redirect()->route('client.height.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $height = Height::findOrFail($id);
        return view('client.pages.height.show', compact('height'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Height $height)
    {
        return view('client.pages.height.edit', compact('height'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHeightRequest $request, string $id)
    {
        $height = Height::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($height->attachment_url) {
                $oldPath = str_replace('storage/', '', $height->attachment_url);
                Storage::disk('public')->delete($oldPath);
            }

            $file = $request->file('attachment');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs(auth()->id() . '/heights', $fileName, 'public');
            $data['attachment_url'] = 'storage/' . $path;
        } elseif ($request->input('remove_attachment') == '1') {
            if ($height->attachment_url) {
                $oldPath = str_replace('storage/', '', $height->attachment_url);
                Storage::disk('public')->delete($oldPath);
            }
            $data['attachment_url'] = null;
        }

        // Check if there's another record with the same user_id and recorded_at
        $existingRecord = Height::where('user_id', auth()->id())
            ->where('recorded_at', $data['recorded_at'])
            ->where('id', '!=', $height->id)
            ->first();

        if ($existingRecord) {
            // Overwrite existing record and delete current one
            $existingRecord->update($data);
            $height->delete();
        } else {
            $height->update($data);
        }

        flash()->success(__('message.height.update_success'), [], __('notification.success'));
        return redirect()->route('client.height.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Height $height)
    {
        if ($height->attachment_url) {
            $oldPath = str_replace('storage/', '', $height->attachment_url);
            Storage::disk('public')->delete($oldPath);
        }

        $height->delete();

        flash()->success(__('message.height.delete_success'), [], __('notification.success'));
        return redirect()->route('client.height.index');
    }
}
