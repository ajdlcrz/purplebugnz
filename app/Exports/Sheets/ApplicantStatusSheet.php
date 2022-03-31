<?php

namespace App\Exports\Sheets;

use App\Applicant;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ApplicantStatusSheet implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithTitle
{
    private $column;
    private $order;
    private $status;
    private $startDate;
    private $endDate;

    public function __construct($filters, $status)
    {
        $this->column = $filters['column'];
        $this->order = $filters['order'];
        $this->startDate = $filters['startDate'];
        $this->endDate = $filters['endDate'];
        $this->status = $status;
    }

    public function query()
    {
        return Applicant::when($this->status !== "all", function ($queryStatus, $status) {
            $queryStatus->where('applicants.status', $this->status);
        })
            ->when($this->column == 'career', function ($query, $sortBy) {
                return $query->join('careers', 'applicants.career_id', '=', 'careers.id')
                    ->orderBy('careers.title', $this->order)
                    ->select('applicants.*');
            }, function ($query) {
                return $query->orderBy($this->column, $this->order);
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                $startDate =  \Carbon\Carbon::parse($this->startDate)->format('Y-m-d');
                $endDate =  \Carbon\Carbon::parse($this->endDate)->format('Y-m-d');

                $query->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate);
            });
    }

    public function map($applicant): array
    {
        return [
            $applicant->career->title,
            Str::title($applicant->status),
            $applicant->name,
            $applicant->contact,
            $applicant->email,
            $applicant->address,
            $applicant->created_at
        ];
    }

    public function headings(): array
    {
        return [
            'Applying For',
            'Status',
            'Full Name',
            'Contact No.',
            'Email Address',
            'Address',
            'Date Applied'
        ];
    }

    public function title(): string
    {
        return Str::title($this->status);
    }
}
