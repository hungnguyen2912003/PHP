<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ContestDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Contest\StoreRequest;
use App\Http\Requests\Admin\Contest\UpdateRequest;
use App\Models\Contest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ContestDataTable $dataTable)
    {
        return $dataTable->render('admin.pages.contest.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.contest.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_url'] = '/storage/' . $request->file('image')->store('contests', 'public');
        }

        $data['status'] = 'inprogress';

        Contest::create($data);

        return redirect()->route('admin.contests.index')->with('success', __('message.contest_created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contest = Contest::findOrFail($id);
        return view('admin.pages.contest.show', compact('contest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contest = Contest::findOrFail($id);
        return view('admin.pages.contest.edit', compact('contest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $contest = Contest::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($contest->image_url && Storage::disk('public')->exists(str_replace('/storage/', '', $contest->image_url))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $contest->image_url));
            }
            $data['image_url'] = '/storage/' . $request->file('image')->store('contests', 'public');
        } elseif ($request->input('remove_image') == '1') {
            if ($contest->image_url && Storage::disk('public')->exists(str_replace('/storage/', '', $contest->image_url))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $contest->image_url));
            }
            $data['image_url'] = null;
        }

        $contest->update($data);

        return redirect()->route('admin.contests.index')->with('success', __('message.contest_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contest = Contest::findOrFail($id);

        if ($contest->image_url && Storage::disk('public')->exists(str_replace('/storage/', '', $contest->image_url))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $contest->image_url));
        }

        $contest->delete();

        return redirect()->route('admin.contests.index')->with('success', __('message.contest_deleted_successfully'));
    }
}
