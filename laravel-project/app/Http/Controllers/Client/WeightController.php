<?php

namespace App\Http\Controllers\Client;

use App\Models\Weight;
use Illuminate\Http\Request;
use App\Http\Requests\WeightRequest;
use App\Http\Resources\WeightResource;

class WeightController extends Controller
{
    public function index()
    {
        $weights = Weight::all();
        return WeightResource::collection($weights);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WeightRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('weights', 'public');
            $data['attachment'] = $path;
        }

        $weight = Weight::create($data);

        return WeightResource::make($weight);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $weight = Weight::findOrFail($id);
        return WeightResource::make($weight);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WeightRequest $request, $id)
    {
        $weight = Weight::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('attachment')) {
            if ($weight->attachment) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($weight->attachment);
            }
            $path = $request->file('attachment')->store('weights', 'public');
            $data['attachment'] = $path;
        }

        $weight->update($data);

        return WeightResource::make($weight);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $weight = Weight::findOrFail($id);
        
        if ($weight->attachment) {
             \Illuminate\Support\Facades\Storage::disk('public')->delete($weight->attachment);
        }

        $weight->delete();

        return response()->noContent();
    }
}
