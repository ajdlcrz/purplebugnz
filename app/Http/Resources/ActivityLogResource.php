<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityLogResource extends JsonResource
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
            'subject' => $this->subject,
            'description' => ucfirst($this->description),
            'causer_id' => $this->causer_id ?? 'N/A',
            'custom_id' => $this->causer_id ? $this->causer->customId : "N/A",
            'causer_name' => $this->causer->name ?? "N/A",
            'causer_ip' => $this->causer_ip,
            'created_at' => strtoupper($this->created_at->format('d M Y, H:i')),
            'properties' => $this->properties,
        ];
    }
}
