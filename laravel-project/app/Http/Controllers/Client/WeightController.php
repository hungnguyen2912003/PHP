<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Weight;
use App\DataTables\WeightDataTable;
use App\Http\Requests\Client\Weight\StoreWeightRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WeightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(WeightDataTable $dataTable)
    {
        return $dataTable->render('client.pages.weight.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('client.pages.weight.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(Weight $weight)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Weight $weight)
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
    public function update(Request $request, Weight $weight)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Weight $weight)
    {
        //
    }
}
