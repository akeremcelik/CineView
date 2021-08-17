<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function visionfilms() {
        return $this->hasMany(VisionFilm::class);
    }

    public function tickets(){
        return $this->hasManyThrough(Ticket::class, VisionFilm::class, 'film_id', 'visionfilm_id');
    }
}
