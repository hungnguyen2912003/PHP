<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ContestDataTable;
use App\DataTables\ContestDetailDataTable;
use App\DataTables\FinalRankingDataTable;
use App\DataTables\TemporaryRankingDataTable;
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

        // Map localized arrays to individual columns
        $localeMap = ['en' => 'en', 'ja' => 'ja', 'zh' => 'zh', 'vi' => 'vi'];

        foreach (['name' => 'name', 'description' => 'desc'] as $input => $prefix) {
            if (isset($data[$input]) && is_array($data[$input])) {
                foreach ($localeMap as $formKey => $colSuffix) {
                    $data["{$prefix}_{$colSuffix}"] = $data[$input][$formKey] ?? null;
                }
                unset($data[$input]);
            }
        }

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

        if ($type === 'final') {
            return (new FinalRankingDataTable($contest))->ajax();
        }

        return (new TemporaryRankingDataTable($id))->ajax();
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
        $filename = 'ranking_' . str_replace(' ', '_', $contest->name_en) . '_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new ContestRankingExport($contest), $filename);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $contest = Contest::findOrFail($id);
        $data = $request->validated();

        // Map localized arrays to individual columns
        $localeMap = ['en' => 'en', 'ja' => 'ja', 'zh' => 'zh', 'vi' => 'vi'];

        foreach (['name' => 'name', 'description' => 'desc'] as $input => $prefix) {
            if (isset($data[$input]) && is_array($data[$input])) {
                foreach ($localeMap as $formKey => $colSuffix) {
                    $data["{$prefix}_{$colSuffix}"] = $data[$input][$formKey] ?? null;
                }
                unset($data[$input]);
            }
        }

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
