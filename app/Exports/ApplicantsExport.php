<?php

namespace App\Exports;

use App\Exports\Sheets\ApplicantStatusSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ApplicantsExport implements WithMultipleSheets
{
    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function sheets(): array
    {
        $statuses = [
            "pending",
            "processed",
            "interviewed",
            "hired",
            "rejected",
            "for reference",
        ];
        if ($this->filters['status'] !== 'all') {
            $statuses = [$this->filters['status']];
        }

        $sheets = [];
        for ($status = 0; $status < count($statuses); $status++) {
            $sheets[$statuses[$status]] = new ApplicantStatusSheet($this->filters, $statuses[$status]);
        }

        return $sheets;
    }
}
