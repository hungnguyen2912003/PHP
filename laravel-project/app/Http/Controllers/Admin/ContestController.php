<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ContestDataTable;
use App\DataTables\ContestDetailDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Contest\StoreRequest;
use App\Http\Requests\Admin\Contest\UpdateRequest;
use App\Models\Contest;
use App\Models\ContestDetail;
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

        $data['status'] = Contest::STATUS_INPROGRESS;

        Contest::create($data);

        return redirect()->route('admin.contests.index')->with('success', __('message.contest_created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contest = Contest::withCount([
            'details',
            'details as completed_details_count' => function ($query) {
                $query->where('status', \App\Models\ContestDetail::STATUS_COMPLETED);
            }
        ])->findOrFail($id);
        
        $dataTable = new ContestDetailDataTable($id);
        return $dataTable->render('admin.pages.contest.show', compact('contest'));
    }

    /**
     * Show the ranking page for the specified contest.
     */
    public function ranking(string $id)
    {
        $contest = Contest::findOrFail($id);
        return view('admin.pages.contest.ranking', compact('contest'));
    }

    /**
     * Return JSON data for the ranking DataTables.
     */
    public function rankingData(string $id, Request $request)
    {
        $contest = Contest::findOrFail($id);
        $type = $request->query('type');
        
        $query = ContestDetail::with('user')
            ->where('contest_id', $id);

        if ($type === 'temporary') {
            $query->where('status', ContestDetail::STATUS_INCOMPLETED)
                  ->orderByDesc('total_steps');
        } elseif ($type === 'final') {
            $query->where('status', ContestDetail::STATUS_COMPLETED)
                  ->orderBy('end_at', 'asc')
                  ->limit($contest->win_limit);
        }

        return datatables()->eloquent($query)
            ->addIndexColumn()
            ->addColumn('user_info', function ($row) {
                return view('admin.pages.contest.columns.user_info', compact('row'))->render();
            })
            ->editColumn('start_at', function ($row) {
                return $row->start_at ? $row->start_at->format('Y-m-d H:i') : '-';
            })
            ->editColumn('end_at', function ($row) {
                return $row->end_at ? $row->end_at->format('Y-m-d H:i') : '-';
            })
            ->editColumn('total_steps', function ($row) {
                return view('admin.pages.contest.columns.total_steps', compact('row'))->render();
            })
            ->rawColumns(['user_info', 'total_steps'])
            ->make(true);

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
