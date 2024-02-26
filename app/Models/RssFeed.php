<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use Carbon\Carbon;
use Auth;
use Log;

class RssFeed extends Model
{
    use HasFactory, Userstamps;
    protected $fillable = ["rss_feed_link", "created_by"];
    protected function CreatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->diffForHumans(),
        );
    }

    protected function UpdatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->diffForHumans(),
        );
    }

    // protected function SessionStartedAt(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (string $value) => Carbon::parse($value)->diffForHumans(),
    //     );
    // }

    public function storeFeed(string $rssFeedLink, int $refreshInterval, string $intervalType, string $sessionStartedAt) : mixed {

        $rssFeed = $this::userWiseFilter()->first();
        
        if (!$rssFeed) {
            $rssFeed = new $this;
        }

        $rssFeed->rss_feed_link = $rssFeedLink;
        $rssFeed->refresh_interval = $refreshInterval;
        $rssFeed->interval_type = $intervalType;
        $rssFeed->session_started_at = $sessionStartedAt;
        $rssFeed->save();
        return $rssFeed;
    }

    
    public function stopFeed(string $sessionEndedAt) : mixed {
        $rssFeed = $this::userWiseFilter()->first();
        $rssFeed->session_ended_at = $sessionEndedAt;
        $rssFeed->save();
        return $rssFeed;
    }

    public function list() {
        return $this::userWiseFilter()->first();
    }

    public function rssFeedDetails(): mixed
    {
        return $this->hasMany(RssFeedDetail::class);
    }

    public function scopeUserWiseFilter($query) : void {
        $query->where("created_by", Auth::id());
    }
    
}
