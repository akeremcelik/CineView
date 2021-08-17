<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisionFilm extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function film() {
        return $this->belongsTo(Film::class);
    }

    public function tickets() {
        return $this->hasMany(Ticket::class, 'visionfilm_id');
    }

    public function cinema() {
        return $this->belongsTo(Cinema::class);
    }
}
