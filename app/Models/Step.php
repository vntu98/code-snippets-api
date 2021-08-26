<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Step extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'title',
        'body',
        'uuid'
    ];

    protected static function booted()
    {
        static::creating(function (Step $step) {
            $step->uuid = Str::uuid();
        });
    }
}
