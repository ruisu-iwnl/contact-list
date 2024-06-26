<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'address',
        'notes',
        'avatar', // Ensure avatar is fillable
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Accessor for avatar attribute to prepend storage path.
     *
     * @param  mixed  $value
     * @return string|null
     */
    public function getAvatarAttribute($value)
    {
        if ($value) {
            return Storage::url($value); // Prepend storage path to avatar
        }

        return null;
    }

    /**
     * Mutator for avatar attribute to store only the path.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setAvatarAttribute($value)
    {
        // Store only the path in the database
        $this->attributes['avatar'] = $value;
    }

    /**
     * Store avatar image data in Redis.
     *
     * @param  mixed  $imageData
     * @return void
     */
    public function storeAvatarInRedis($imageData)
    {
        $redisKey = 'avatar:' . Str::uuid(); // Generate a unique key for the avatar
        Redis::set($redisKey, $imageData); // Store the image data in Redis

        // Update the avatar attribute in the database with the Redis key
        $this->avatar = $redisKey;
        $this->save();
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
