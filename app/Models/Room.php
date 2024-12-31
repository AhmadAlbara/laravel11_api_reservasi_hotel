<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_type_id',
        'hotel_id',
        'room_number',
        'price',
        'status',
    ];

    // Relasi dengan room type
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    // Relasi dengan hotel
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    // Relasi dengan reservation
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}

