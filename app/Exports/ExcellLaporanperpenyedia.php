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

class ExcellLaporanperpenyedia implements FromView, WithStyles,  WithEvents, WithDrawings
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('laporan.laporanperpenyediaexcel', $this->data);
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
        $drawing->setOffsetX(100);
        $drawing->setOffsetY(10);
        return [$drawing];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('G:H')->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('A')->getNumberFormat()->setFormatCode('@');
        $sheet->getStyle('A7:F8')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A7:F8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A7:F8')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            },
        ];
    }
}
