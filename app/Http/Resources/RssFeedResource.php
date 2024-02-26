<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RssFeedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'rss_feed_id'        => $this->id,
            'rss_feed_link'      => $this->rss_feed_link,
            'refresh_interval'   => $this->refresh_interval,
            'interval_type'      => $this->interval_type,
            'session_started_at' => $this->session_started_at,
            'session_ended_at'   => $this->session_ended_at,
            'created_at'         => $this->created_at,
            'updated_at'         => $this->updated_at,
            'creator'            => $this->creator,
            'editor'             => $this->editor,
            'details'            => $this->rssFeedDetails,
        ];
    }
}
