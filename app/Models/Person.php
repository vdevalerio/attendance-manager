<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
    ];

    public function attendances()
    {
        return $this->belongsToMany(Attendance::class)->withTimestamps();
    }
}
