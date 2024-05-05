<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;

    protected $table = 'lectures';

    public function primjeri()
    {
        return $this->hasMany(Example::class);
    }

    public function sekcija()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
