<?php

namespace App\Exports;

use App\Models\Contest;
use App\Models\ContestDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ContestRankingExport implements FromCollection, WithHeadings, WithTitle, WithEvents, WithColumnWidths
{
    private const LAST_COLUMN = 'H';

    private const CONTEST_TYPES = [
        1 => 'value.contest_type.walking',
        2 => 'value.contest_type.running',
        3 => 'value.contest_type.cycling',
        4 => 'value.contest_type.swimming',
    ];

    private const STATUS_MAP = [
        Contest::STATUS_INPROGRESS => 'value.status.inprogress',
        Contest::STATUS_COMPLETED  => 'value.status.completed',
        Contest::STATUS_CANCELLED  => 'value.status.cancelled',
    ];

    public function __construct(protected Contest $contest) {}

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
        $contest = $this->contest;

        return ContestDetail::with('user')
            ->where('contest_id', $contest->id)
            ->orderByDesc('total_steps')
            ->get()
            ->map(function ($detail, $index) use ($contest) {
                $rank = $index + 1;
                $eligible = $detail->total_steps >= $contest->target && $rank <= $contest->win_limit;

                return [
                    $rank,
                    $detail->user?->fullname ?? '-',
                    $detail->user?->email ?? '-',
                    $detail->start_at?->format('Y-m-d H:i:s') ?? '-',
                    $detail->end_at?->format('Y-m-d H:i:s') ?? '-',
                    Contest::formatDuration($detail->start_at, $detail->end_at),
                    $detail->total_steps ?? 0,
                    $eligible ? $contest->calculateReward($rank) : 0,
                ];
            });
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,  'B' => 25, 'C' => 30, 'D' => 22,
            'E' => 22, 'F' => 15, 'G' => 15, 'H' => 18,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $contest = $this->contest;
                $col = self::LAST_COLUMN;

                $contestInfo = [
                    [__('label.contest_name'),  $contest->name],
                    [__('label.type'),          __(self::CONTEST_TYPES[$contest->type] ?? 'value.unknown')],
                    [__('label.target'),        $contest->target],
                    [__('label.reward_points'), $contest->reward_points],
                    [__('label.win_limit'),     $contest->win_limit],
                    [__('label.start_date'),    $contest->start_date?->format('Y-m-d')],
                    [__('label.end_date'),      $contest->end_date?->format('Y-m-d')],
                    [__('label.status'),        __(self::STATUS_MAP[$contest->status] ?? 'value.unknown')],
                ];

                $infoRowCount = count($contestInfo);
                $totalShift = $infoRowCount + 2; // title row + blank row
                $sheet->insertNewRowBefore(1, $totalShift);

                // Contest info title
                $this->styleContestTitle($sheet, $col);

                // Contest info rows
                $this->writeContestInfo($sheet, $contestInfo);

                // Ranking table styles
                $headerRow = $totalShift + 1;
                $lastDataRow = $sheet->getHighestRow();
                $this->styleRankingTable($sheet, $headerRow, $lastDataRow, $col);
            },
        ];
    }

    private function styleContestTitle(Worksheet $sheet, string $col): void
    {
        $sheet->setCellValue('A1', __('label.contest_information'));
        $sheet->mergeCells("A1:{$col}1");
        $style = $sheet->getStyle('A1');
        $style->getFont()->setBold(true)->setSize(14)->getColor()->setRGB('FFFFFF');
        $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $style->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
    }

    private function writeContestInfo(Worksheet $sheet, array $rows): void
    {
        foreach ($rows as $i => [$label, $value]) {
            $row = $i + 2;
            $sheet->setCellValue("A{$row}", $label);
            $sheet->setCellValue("B{$row}", $value);
            $sheet->getStyle("A{$row}")->getFont()->setBold(true);
            $sheet->getStyle("A{$row}:B{$row}")->getBorders()->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);
        }
    }

    private function styleRankingTable(Worksheet $sheet, int $headerRow, int $lastRow, string $col): void
    {
        $headerRange = "A{$headerRow}:{$col}{$headerRow}";
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()
            ->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D9E2F3');
        $sheet->getStyle($headerRange)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($headerRange)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        if ($lastRow <= $headerRow) {
            return;
        }

        $dataStart = $headerRow + 1;
        $sheet->getStyle("A{$dataStart}:{$col}{$lastRow}")->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle("A{$dataStart}:A{$lastRow}")->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("G{$dataStart}:{$col}{$lastRow}")->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    }
}
