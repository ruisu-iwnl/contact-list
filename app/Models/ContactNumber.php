<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactNumber extends Model
{
    use HasFactory;

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
