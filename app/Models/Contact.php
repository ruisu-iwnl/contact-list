<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'address',
        'notes',
        'avatar',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Get the avatar attribute and decode it from binary to displayable format.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function getAvatarAttribute($value)
    {
        // Check if the value is not null and starts with "0x"
        if ($value && strpos($value, '0x') === 0) {
            // Remove the "0x" prefix
            $hexData = substr($value, 2);
            // Convert hex to binary
            return hex2bin($hexData);
        }

        return null;
    }

    /**
     * Set the avatar attribute and encode it as hexadecimal for storage.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setAvatarAttribute($value)
    {
        // Store as hexadecimal
        $this->attributes['avatar'] = '0x' . bin2hex($value);
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
