<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsmarket extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'title',
        'pdf_url',
    ];
}