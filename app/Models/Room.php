<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['name', 'slug', 'user_id'];

    public function messages()
    {
        return $this->hasMany(RoomMessage::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'room_user');
    }
}
