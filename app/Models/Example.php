<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Example extends Model
{
    use HasFactory;

    protected $table = 'examples';

    public function lekcija()
    {
        return $this->belongsTo(Lecture::class,'lecture_id');
    }
}
