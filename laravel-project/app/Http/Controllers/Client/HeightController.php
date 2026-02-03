<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Height;
use App\DataTables\HeightDataTable;
use App\Http\Requests\Client\Height\StoreHeightRequest;
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

        Height::create($data);

        flash()->success(__('message.height.create_success'), [], __('notification.success'));
        return redirect()->route('client.height.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Height $height)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Height $height)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function editPost(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Height $height)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Height $height)
    {
        //
    }
}
