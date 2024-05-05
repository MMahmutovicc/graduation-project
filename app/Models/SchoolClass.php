<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'school_classes';

    public function ucenik()
    {
        return $this->hasMany(User::class);
    }

    public function events()
    {
        return $this->hasMany(ClassEvent::class, 'school_class_id');
    }
}
