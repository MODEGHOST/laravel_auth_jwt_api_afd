<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vdomeet extends Model
{
    protected $table = 'vdomeet';

    protected $fillable = [
        'title',
        'youtube_link',
        'published_date'
    ];
}
