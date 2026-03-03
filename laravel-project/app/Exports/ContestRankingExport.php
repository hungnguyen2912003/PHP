<?php

namespace App\Exports;

use App\Models\Contest;
use App\Models\ContestDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ContestRankingExport implements FromCollection, WithHeadings, WithTitle, WithEvents, WithColumnWidths, WithStyles
{
    protected Contest $contest;
    protected int $contestInfoRows = 0;

    public function __construct(Contest $contest)
    {
        $this->contest = $contest;
    }

    public function title(): string
    {
        return __('button.ranking');
    }

    public function headings(): array
    {
        return [
            __('label.stt'),
            __('label.participants'),
            'Email',
            __('label.start_at'),
            __('label.end_at'),
            __('label.duration'),
            __('label.total_steps'),
            __('label.reward_points'),
        ];
    }

    public function collection()
    {
        $details = ContestDetail::with('user')
            ->where('contest_id', $this->contest->id)
            ->orderByDesc('total_steps')
            ->get();

        return $details->map(function ($detail, $index) {
            $duration = '-';
            if ($detail->start_at && $detail->end_at) {
                $seconds = abs($detail->start_at->diffInSeconds($detail->end_at));
                $h = intdiv($seconds, 3600);
                $m = intdiv($seconds % 3600, 60);
                $s = $seconds % 60;
                $duration = sprintf('%02d:%02d:%02d', $h, $m, $s);
            }

            $rank = $index + 1;
            $rewardPoints = $this->calculateReward($rank, $detail, $this->contest);

            return [
                $rank,
                $detail->user?->fullname ?? '-',
                $detail->user?->email ?? '-',
                $detail->start_at ? $detail->start_at->format('Y-m-d H:i:s') : '-',
                $detail->end_at ? $detail->end_at->format('Y-m-d H:i:s') : '-',
                $duration,
                $detail->total_steps,
                $rewardPoints,
            ];
        });
    }

    /**
     * Calculate reward points based on rank position.
     * Only participants who reached the target and are within win_limit get rewards.
     * Top 1: 100%, Top 2: 80%, Top 3: 70%, Top 4+: 60%
     */
    private function calculateReward(int $rank, ContestDetail $detail, Contest $contest): int
    {
        if ($detail->total_steps < $contest->target || $rank > $contest->win_limit) {
            return 0;
        }

        return match (true) {
            $rank === 1 => $contest->reward_points,
            $rank === 2 => (int) round($contest->reward_points * 0.8),
            $rank === 3 => (int) round($contest->reward_points * 0.7),
            default => (int) round($contest->reward_points * 0.6),
        };
    }

    private function getContestTypeName(int $type): string
    {
        return match ($type) {
            1 => __('value.contest_type.walking'),
            2 => __('value.contest_type.running'),
            3 => __('value.contest_type.cycling'),
            4 => __('value.contest_type.swimming'),
            default => __('value.unknown'),
        };
    }

    private function getStatusName(int $status): string
    {
        return match ($status) {
            Contest::STATUS_INPROGRESS => __('value.status.inprogress'),
            Contest::STATUS_COMPLETED => __('value.status.completed'),
            Contest::STATUS_CANCELLED => __('value.status.cancelled'),
            default => __('value.unknown'),
        };
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 25,
            'C' => 30,
            'D' => 22,
            'E' => 22,
            'F' => 15,
            'G' => 15,
            'H' => 18,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [];
    }

    public function registerEvents(): array
    {
        $contest = $this->contest;

        return [
            AfterSheet::class => function (AfterSheet $event) use ($contest) {
                $sheet = $event->sheet->getDelegate();

                // Contest information rows
                $contestInfo = [
                    [__('label.contest_name'), $contest->name],
                    [__('label.type'), $this->getContestTypeName($contest->type)],
                    [__('label.target'), $contest->target],
                    [__('label.reward_points'), $contest->reward_points],
                    [__('label.win_limit'), $contest->win_limit],
                    [__('label.start_date'), $contest->start_date?->format('Y-m-d')],
                    [__('label.end_date'), $contest->end_date?->format('Y-m-d')],
                    [__('label.status'), $this->getStatusName($contest->status)],
                ];

                $infoRowCount = count($contestInfo);
                // +2 for: title row + blank row after info
                $totalShift = $infoRowCount + 2;

                // Shift existing data (headings + data rows) down
                $highestRow = $sheet->getHighestRow();
                $highestCol = $sheet->getHighestColumn();

                // Move rows from bottom to top to avoid overwriting
                for ($row = $highestRow; $row >= 1; $row--) {
                    for ($col = 'A'; $col <= $highestCol; $col++) {
                        $value = $sheet->getCell($col . $row)->getValue();
                        $sheet->setCellValue($col . ($row + $totalShift), $value);
                        $sheet->setCellValue($col . $row, null);
                    }
                }

                // Write contest info title
                $sheet->setCellValue('A1', __('label.contest_information'));
                $sheet->mergeCells('A1:H1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
                $sheet->getStyle('A1')->getFont()->getColor()->setRGB('FFFFFF');

                // Write contest info rows
                for ($i = 0; $i < $infoRowCount; $i++) {
                    $rowNum = $i + 2;
                    $sheet->setCellValue('A' . $rowNum, $contestInfo[$i][0]);
                    $sheet->setCellValue('B' . $rowNum, $contestInfo[$i][1]);
                    $sheet->getStyle('A' . $rowNum)->getFont()->setBold(true);
                    $sheet->getStyle('A' . $rowNum . ':B' . $rowNum)->getBorders()->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN);
                }

                // Style the ranking header row
                $headerRow = $totalShift + 1;
                $sheet->getStyle("A{$headerRow}:H{$headerRow}")->getFont()->setBold(true);
                $sheet->getStyle("A{$headerRow}:H{$headerRow}")->getFill()
                    ->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D9E2F3');
                $sheet->getStyle("A{$headerRow}:H{$headerRow}")->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("A{$headerRow}:H{$headerRow}")->getBorders()->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Style data rows with borders
                $lastDataRow = $sheet->getHighestRow();
                if ($lastDataRow > $headerRow) {
                    $sheet->getStyle("A" . ($headerRow + 1) . ":H{$lastDataRow}")->getBorders()->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN);
                    $sheet->getStyle("A" . ($headerRow + 1) . ":A{$lastDataRow}")->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("G" . ($headerRow + 1) . ":H{$lastDataRow}")->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                }
            },
        ];
    }
}
