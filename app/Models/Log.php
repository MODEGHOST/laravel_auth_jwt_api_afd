<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = ['admin_id', 'action', 'description', 'ip_address'];

    public function admin()
    {
        return $this->belongsTo(Adminofgod::class, 'admin_id');
    }
}
