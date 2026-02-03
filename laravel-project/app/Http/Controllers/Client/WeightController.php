<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Weight;
use App\DataTables\WeightDataTable;
use App\Http\Requests\Client\Weight\StoreWeightRequest;
use App\Http\Requests\Client\Weight\UpdateWeightRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WeightController extends Controller
{
    public function index(WeightDataTable $dataTable)
    {
        return $dataTable->render('client.pages.weight.index');
    }

    public function create()
    {
        return view('client.pages.weight.create');
    }

    public function store(StoreWeightRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs(auth()->id() . '/weights', $fileName, 'public');
            $data['attachment_url'] = 'storage/' . $path;
        }

        Weight::create($data);

        flash()->success(__('message.weight.create_success'), [], __('notification.success'));
        return redirect()->route('client.weight.index');
    }

    public function show(string $id)
    {
        $weight = Weight::findOrFail($id);
        return view('client.pages.weight.show', compact('weight'));
    }

    public function edit(string $id)
    {
        $weight = Weight::findOrFail($id);
        return view('client.pages.weight.edit', compact('weight'));
    }


    public function update(UpdateWeightRequest $request, string $id)
    {
        $weight = Weight::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($weight->attachment_url) {
                $oldPath = str_replace('storage/', '', $weight->attachment_url);
                Storage::disk('public')->delete($oldPath);
            }

            $file = $request->file('attachment');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs(auth()->id() . '/weights', $fileName, 'public');
            $data['attachment_url'] = 'storage/' . $path;
        } elseif ($request->input('remove_attachment') == '1') {
            if ($weight->attachment_url) {
                $oldPath = str_replace('storage/', '', $weight->attachment_url);
                Storage::disk('public')->delete($oldPath);
            }
            $data['attachment_url'] = null;
        }

        $weight->update($data);

        flash()->success(__('message.weight.update_success'), [], __('notification.success'));
        return redirect()->route('client.weight.index');
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
        return redirect()->route('client.weight.index');
    }
}
