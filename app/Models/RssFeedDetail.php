<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use Auth;
use Log;

class RssFeedDetail extends Model
{
    use HasFactory, Userstamps;

    protected $fillable = [
        'rss_feed_id',
        'title',
        'link',
        'published_at'
    ];
    
    public function storeRssFeedDetail(int $rssFeedId, array $rssFeedDetails): mixed {
        
        if (count($rssFeedDetails)) {

            foreach ($rssFeedDetails as $key => $data) {
                
                $rssFeedDetail = $this::where([
                    ['rss_feed_id', $rssFeedId],
                    ['link', $data['link']],
                    ['created_by', Auth::id()],
                    ])->first();

                if ($rssFeedDetail) {
                    $rssFeedDetail->status = "old";                    
                    $rssFeedDetail->rss_feed_id  = $rssFeedId;
                    $rssFeedDetail->title        = $data['title'];
                    $rssFeedDetail->link         = $data['link'];
                    $rssFeedDetail->published_at = $data['published_at'];
                    $rssFeedDetail->save();
                } else {
                    $rssFeedDetail = new $this;
                    $rssFeedDetail->status = "new";
                    $rssFeedDetail->rss_feed_id  = $rssFeedId;
                    $rssFeedDetail->title        = $data['title'];
                    $rssFeedDetail->link         = $data['link'];
                    $rssFeedDetail->published_at = $data['published_at'];
                    $rssFeedDetail->save();
                }

            }
        }

        return true;

    }

}
