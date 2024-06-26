<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactNumber extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contact_id',
        'number',
    ];

    protected $table = 'contacts_numbers'; 


    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
