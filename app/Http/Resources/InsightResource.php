<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class InsightResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => Str::limit($this->title, 29),
            'details' => Str::limit(strip_tags($this->details), 200),
            'thumbnail' => asset($this->thumbnailPath),
            'altText' => $this->alt_text,
            'published' => $this->published_at,
            'url' => url("insight/{$this->slug}"),
        ];
    }
}
