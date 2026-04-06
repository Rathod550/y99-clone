<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['name', 'slug'];

    public function messages()
    {
        return $this->hasMany(RoomMessage::class);
    }
}
