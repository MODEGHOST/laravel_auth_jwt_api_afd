<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanState extends Model
{
    protected $table = 'finan_state';
    protected $fillable = ['title', 'year', 'description', 'quater', 'pdf_url'];
}

