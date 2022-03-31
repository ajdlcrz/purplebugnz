<?php

namespace App\Exports;

use App\Influencer;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InfluencersExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    public function __construct($column, $order)
    {
        $this->column = $column;
        $this->order = $order;
    }

    public function query()
    {
        return Influencer::orderBy($this->column, $this->order);
    }

    public function map($influencers): array
    {
        $facebook = [
            $influencers->facebook['page_url'] ?? "N/A",
            $influencers->facebook['post_rate'] ?? "N/A"
        ];

        $instagram = [
            $influencers->instagram['page_url'] ?? "N/A",
            $influencers->instagram['post_rate'] ?? "N/A",
            $influencers->instagram['video_post_rate'] ?? "N/A"
        ];

        $youtube = [
            $influencers->youtube['page_url'] ?? "N/A",
            $influencers->youtube['post_rate'] ?? "N/A"
        ];

        $tiktok = [
            $influencers->tiktok['page_url'] ?? "N/A",
            $influencers->tiktok['post_rate'] ?? "N/A"
        ];

        $contents = "";

        foreach ($influencers->content_category as $key => $contentType) {
            if ($contentType == true && $key !== 'others') {
                $category = \Str::title($key);
                $contents .= "{$category}, ";
            } elseif ($key == 'others' && !empty($influencers->content_category['others'])) {
                $contents .= "Others: {$contentType}, ";
            }
        }

        return [
            $influencers->name,
            $influencers->email,
            $influencers->contact_number,
            $influencers->age,
            $influencers->sex,
            $influencers->created_at->format("Y-m-d"),
            $influencers->total_followers,
            $contents,
            "Page URL: {$facebook[0]}, Post Rate: {$facebook[1]}",
            "Page URL: {$instagram[0]}, Post Rate: {$instagram[1]}, Video Post Rate: {$instagram[2]}",
            "Page URL: {$youtube[0]}, Post Rate: {$youtube[1]}",
            "Page URL: {$tiktok[0]}, Post Rate: {$tiktok[1]}",
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Contact No.',
            'Age',
            'Sex',
            'Date Registered',
            'Total Followers (est.)',
            'Content Types',
            'Facebook',
            'Instagram',
            'Youtube',
            'Tiktok'
        ];
    }
}
