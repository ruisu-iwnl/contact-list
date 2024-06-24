<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'useraccounts'; 

    protected $fillable = [
        'username',
        'password',
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
