<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; 

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'activity_description',
        'old_values',
        'new_values',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
