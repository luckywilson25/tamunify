<?php

namespace App\Exports;

use App\Models\Visitor;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class VisitorExport implements FromQuery, WithMapping, WithHeadings, WithChunkReading, WithStyles, ShouldAutoSize, WithProperties
{
    use Exportable;
    private $status;
    private $type;
    private $rowNumber = 0;

    public function __construct($status, $type)
    {
        $this->status = $status;
        $this->type = $type;
    }

    public function properties(): array
    {
        return [
            'creator' => 'Fitra Fajar',
            'lastModifiedBy' => 'Fitra Fajar',
            'title' => 'Data Tamu',
            'description' => 'Data Tamu',
            'subject' => 'Data Tamu',
            'keywords' => 'tamu',
            'category' => 'tamu',
            'manager' => 'Fitra Fajar',
        ];
    }

    public function query()
    {
        $query = Visitor::with(['general', 'internship', 'recurring'])->select('visitors.*');

        if ($this->status != '' && $this->status != 'All') {
            $query->where('status', $this->status);
        }
        if ($this->type != '' && $this->type != 'All') {
            $query->where('type', $this->type);
        }

        $query->orderBy('name');

        return $query;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function map($visitor): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $visitor->name,
            $visitor->type->value,
            $visitor->general ? $visitor->general->company : ($visitor->internship ? $visitor->internship->institution : $visitor->recurring->company),
            $visitor->general ? $visitor->general->person_to_meet : ($visitor->internship ? '-' : $visitor->recurring->related_to),
            $visitor->general ? $visitor->general->department->value : ($visitor->internship ? $visitor->internship->department->value : $visitor->recurring->department->value),
            $visitor->status,
        ];
    }
    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Tipe Tamu',
            'Instansi / Institusi',
            'Orang yang dituju',
            'Departemen',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'font' => [
                'size' => 12,
                'name' => 'Times New Roman'
            ],
        ];
        $sheet->getStyle('A2:G' . $this->rowNumber + 1)->applyFromArray($styleArray);
        $sheet->getStyle('A1:G1')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'font' => [
                'bold' => true,
                'size' => 13,
                'name' => 'Times New Roman'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);
    }
}
