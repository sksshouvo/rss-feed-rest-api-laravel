<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RssFeedDetail extends Model
{
    use HasFactory;
    
    public function storeRssFeed(string $rssFeedLink, int $refreshInterval, string $intervalType, string $sessionstartedAt): mixed {
        $rssFeed = new $this;
        $rssFeed->rss_feed_link = $rssFeedLink;
        $rssFeed->refresh_interval = $refreshInterval;
        $rssFeed->interval_type = $intervalType;
        $rssFeed->session_started_at = $sessionstartedAt;
        $rssFeed->save();
        return $rssFeed;
    }
}
