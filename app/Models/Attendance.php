<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['group_id'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function people()
    {
        return $this->belongsToMany(Person::class)->withTimestamps();
    }
}
