<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'operator_id',
        'name',
        'description',
        'latitude',
        'longitude',
        'address',
        'city',
        'country',
    ];


    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }


    public function roomTypes()
    {
        return $this->hasMany(RoomType::class);
    }

 
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

 
    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }


    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
