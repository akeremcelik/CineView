<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function visionfilms(){
        return $this->hasMany(VisionFilm::class);
    }

    public function tickets(){
        return $this->hasManyThrough(Ticket::class, VisionFilm::class, 'cinema_id', 'visionfilm_id');
    }
}
