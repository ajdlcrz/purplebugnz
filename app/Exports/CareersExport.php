<?php

namespace App\Exports;

use App\Career;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CareersExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithColumnWidths
{
    public function __construct($column, $order)
    {
        $this->column = $column;
        $this->order = $order;
    }

    public function query()
    {
        return Career::orderBy($this->column, $this->order);
    }

    public function map($careers): array
    {
        return [
            $careers->title,
            $careers->department ?? 'N/A',
            $careers->experience ?? '0',
            strip_tags($careers->overview),
            strip_tags($careers->requirements),
            $careers->status ? 'Active' : 'Inactive',

        ];
    }

    public function columnWidths(): array
    {
        return [
            'D' => 45,
            'E' => 45,
        ];
    }

    public function headings(): array
    {
        return [
            'Job Title',
            'Department',
            'Years of Experience',
            'Overview',
            'Requirements',
            'Status'
        ];
    }
}
