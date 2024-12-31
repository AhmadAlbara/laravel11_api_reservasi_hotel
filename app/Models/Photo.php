<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'hotel_id',
        'photo_path',
    ];

   
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
