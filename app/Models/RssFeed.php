<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class RssFeed extends Model
{
    use HasFactory, Userstamps;

    
    public function storeFeed(string $rssFeedLink, int $refreshInterval, string $intervalType, string $sessionStartedAt) : mixed {
        $rssFeed = $this;
        $rssFeed->rss_feed_link = $rssFeedLink;
        $rssFeed->refresh_interval = $refreshInterval;
        $rssFeed->interval_type = $intervalType;
        $rssFeed->session_started_at = $sessionStartedAt;
        $rssFeed->save();
        return $rssFeed;
    }

    public function rssFeedDetails(): mixed
    {
        return $this->hasMany(RssFeedDetail::class);
    }
    
}
