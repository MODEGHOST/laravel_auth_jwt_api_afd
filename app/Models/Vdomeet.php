<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vdomeet extends Model
{
    protected $table = 'vdomeet';

    protected $fillable = [
        'title',
        'title_en',
        'youtube_link',
        'published_date'
    ];
}
