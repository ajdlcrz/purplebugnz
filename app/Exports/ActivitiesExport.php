<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Spatie\Activitylog\Models\Activity;

class ActivitiesExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    public function __construct($column, $order)
    {
        $this->column = $column;
        $this->order = $order;
    }

    public function query()
    {
        return Activity::orderBy($this->column, $this->order);
    }

    public function map($activity): array
    {
        $description = 'N/A';
        if (in_array($activity->description, ['LOGGED IN', 'LOGGED OUT'])) {
            $description = $activity->created_at;
        }

        return [
            $description,
            $activity->causer_id,
            $activity->created_at,
            $activity->description,
            $activity->causer_ip,
        ];
    }

    public function headings(): array
    {
        return [
            'Logged In',
            'User ID',
            'Activity Date and Time',
            'Activity Description',
            'IP Address',
        ];
    }
}
