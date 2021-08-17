<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function visionfilm() {
        return $this->belongsTo(VisionFilm::class, 'visionfilm_id');
    }
}
