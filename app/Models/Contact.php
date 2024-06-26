<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'address',
        'notes',
        'photo', // Ensure this matches your database column name
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Accessor for photo attribute to prepend storage path.
     *
     * @param  mixed  $value
     * @return string|null
     */
    public function getPhotoAttribute($value)
    {
        if ($value) {
            // Ensure correct path handling
            if (strpos($value, 'http') === 0 || strpos($value, '/storage/') === 0) {
                return $value;
            }
            return Storage::url($value);
        }
        return null;
    }

    /**
     * Mutator for photo attribute to store only the path.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setPhotoAttribute($value)
    {
        // Store only the path in the database
        $this->attributes['photo'] = $value;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function numbers()
    {
        return $this->hasMany(ContactNumber::class, 'contact_id');
    }
}
