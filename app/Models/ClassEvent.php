<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassEvent extends Model
{
    use HasFactory;

    protected $table = 'class_events';

    public function razred()
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }
}
