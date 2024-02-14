<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class RssFeed extends Model
{
    use HasFactory, Userstamps;

    public function storeRssFeed(string $title, string $link, string $publishedAt): mixed {
        $rssFeed = new $this;
        $rssFeed->title = $title;
        $rssFeed->link = $link;
        $rssFeed->published_at = $publishedAt;
        $rssFeed->save();
        return $rssFeed;
    }
}
