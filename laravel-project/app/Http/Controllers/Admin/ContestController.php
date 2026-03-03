<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ContestDataTable;
use App\DataTables\ContestDetailDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Contest\StoreRequest;
use App\Http\Requests\Admin\Contest\UpdateRequest;
use App\Exports\ContestRankingExport;
use App\Models\Contest;
use App\Models\ContestDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

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
        $data['status'] = Contest::STATUS_INPROGRESS;

        $contest = Contest::create($data);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('contests/' . $contest->id, $fileName, 'public');
            $contest->update(['image_url' => '/storage/' . $path]);
        }

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
                $query->where('status', ContestDetail::STATUS_COMPLETED);
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
            $query->orderByDesc('total_steps');
        } elseif ($type === 'final') {
            // Only show final rank data after contest is finalized
            if ($contest->status !== Contest::STATUS_COMPLETED) {
                return datatables()->eloquent($query->whereRaw('1 = 0'))
                    ->addIndexColumn()
                    ->addColumn('user_info', fn() => '')
                    ->addColumn('duration', fn() => '')
                    ->addColumn('reward_points', fn() => 0)
                    ->make(true);
            }
            $query->where('total_steps', '>=', $contest->target)
                  ->orderByRaw('TIMESTAMPDIFF(SECOND, start_at, end_at) ASC')
                  ->orderBy('start_at', 'asc')
                  ->limit($contest->win_limit);
        }

        $datatable = datatables()->eloquent($query)
            ->addIndexColumn()
            ->addColumn('user_info', function ($row) {
                return view('admin.pages.contest.columns.user_info', compact('row'))->render();
            })
            ->editColumn('start_at', function ($row) {
                return $row->start_at ? $row->start_at->format('Y-m-d H:i:s') : '-';
            })
            ->editColumn('end_at', function ($row) {
                return $row->end_at ? $row->end_at->format('Y-m-d H:i:s') : '-';
            })
            ->editColumn('total_steps', function ($row) {
                return view('admin.pages.contest.columns.total_steps', compact('row'))->render();
            })
            ->rawColumns(['user_info', 'total_steps']);

        if ($type === 'final') {
            $datatable->addColumn('duration', function ($row) {
                if (!$row->start_at || !$row->end_at) return '-';
                $seconds = abs($row->start_at->diffInSeconds($row->end_at));
                $h = intdiv($seconds, 3600);
                $m = intdiv($seconds % 3600, 60);
                $s = $seconds % 60;
                return sprintf('%02d:%02d:%02d', $h, $m, $s);
            });

            // Calculate reward points based on rank
            $response = $datatable->make(true);
            $content = json_decode($response->getContent(), true);

            if (!empty($content['data'])) {
                $rewardPoints = $contest->reward_points;
                foreach ($content['data'] as $index => &$item) {
                    $rank = $index + 1;
                    $item['reward_points'] = $this->calculateReward($rank, $rewardPoints);
                }
            }

            return response()->json($content);
        }

        return $datatable->make(true);
    }

    /**
     * Calculate reward points based on rank position.
     * Top 1: 100%, Top 2: 80%, Top 3: 70%, Top 4+: 60%
     */
    private function calculateReward(int $rank, int $rewardPoints): int
    {
        return match (true) {
            $rank === 1 => $rewardPoints,
            $rank === 2 => (int) round($rewardPoints * 0.8),
            $rank === 3 => (int) round($rewardPoints * 0.7),
            default => (int) round($rewardPoints * 0.6),
        };
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
     * Export the contest ranking to Excel.
     */
    public function exportRanking(string $id)
    {
        $contest = Contest::findOrFail($id);
        $filename = 'ranking_' . str_replace(' ', '_', $contest->name) . '_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new ContestRankingExport($contest), $filename);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $contest = Contest::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($contest->image_url) {
                $oldPath = str_replace('/storage/', '', $contest->image_url);
                Storage::disk('public')->delete($oldPath);
            }

            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('contests/' . $contest->id, $fileName, 'public');
            $data['image_url'] = '/storage/' . $path;
        } elseif ($request->input('remove_image') == '1') {
            if ($contest->image_url) {
                $oldPath = str_replace('/storage/', '', $contest->image_url);
                Storage::disk('public')->delete($oldPath);
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

        if ($contest->image_url) {
            $oldPath = str_replace('/storage/', '', $contest->image_url);
            Storage::disk('public')->delete($oldPath);
        }

        $contest->delete();

        return redirect()->route('admin.contests.index')->with('success', __('message.contest_deleted_successfully'));
    }
}
