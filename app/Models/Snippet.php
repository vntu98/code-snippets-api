<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Snippet extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'title',
        'is_public'
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected static function booted()
    {
        static::created(function (Snippet $snippet) {
            $snippet->steps()->create([
                'order' => 1
            ]);
        });

        static::creating(function (Snippet $snippet) {
            $snippet->uuid = Str::uuid();
        });
    }

    public function isPublic()
    {
        return $this->is_public;
    }

    public function steps()
    {
        return $this->hasMany(Step::class)
            ->orderBy('order', 'asc');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
