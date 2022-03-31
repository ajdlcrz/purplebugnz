<?php

namespace App\Exports;

use App\Insight_Inquiry;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class InsightsExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($column, $order)
    {
        $this->column = $column;
        $this->order = $order;
    }

    public function query()
    {
        return Insight_Inquiry::orderBy($this->column, $this->order);
    }

    public function map($insights): array
    {
        return [
            $insights->title,
            $insights->name,
            $insights->email,
            $insights->company,
            $insights->contact_manager,
            $insights->created_at,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 45,
        ];
    }

    public function headings(): array
    {
        return [
            'Insight Title',
            'Name',
            'Email',
            'Company',
            'Contact Manager',
            'Date',
        ];
    }
}
