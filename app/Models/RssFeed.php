<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class RssFeed extends Model
{
    use HasFactory, Userstamps;

    
    public function rssFeedDetails(): HasMany
    {
        return $this->hasMany(RssFeedDetail::class);
    }
    
}
