<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExcellLaporanpaket implements FromView, WithStyles,  WithEvents, WithDrawings
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('laporan.laporanpaketexcel', $this->data);
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo Pemerintah Daerah');
        $logoPath = 'assets/images/logo_mimika.png';
        $drawing->setPath(public_path($logoPath));
        $drawing->setHeight(90);
        $drawing->setCoordinates('B1');
        $drawing->setOffsetX(200);
        $drawing->setOffsetY(10);
        return [$drawing];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('B2:B10000')->getAlignment()->setWrapText(true);
                $cellRange = 'A2:Z10000';
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
                $columns = ['C', 'D', 'E', 'F', 'G'];
                $rowCount = 10000;

                foreach ($columns as $col) {
                    $range = "{$col}2:{$col}{$rowCount}";
                    $event->sheet->getDelegate()->getStyle($range)->getNumberFormat()
                        ->setFormatCode('"Rp"#,##0.00_-');
                }
            }
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('G:H')->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('A')->getNumberFormat()->setFormatCode('@');
        $sheet->getStyle('A7:T8')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');

        return [];
    }
}
