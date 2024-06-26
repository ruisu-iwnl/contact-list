<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
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
