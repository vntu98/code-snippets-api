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

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected static function booted()
    {
        static::creating(function (Step $step) {
            $step->uuid = Str::uuid();
        });
    }

    public function snippet()
    {
        return $this->belongsTo(Snippet::class);
    }

    public function afterOrder()
    {
        $adjacent = self::where('order', '>', $this->order)
            ->orderBy('order', 'asc')
            ->first();
        
        if (!$adjacent) {
            return self::orderBy('order', 'desc')->first()->order + 1;
        }
        
        return ($this->order + $adjacent->order) / 2;
    }

    public function beforeOrder()
    {
        $adjacent = self::where('order', '<', $this->order)
            ->orderBy('order', 'desc')
            ->first();
        
        if (!$adjacent) {
            return self::orderBy('order', 'asc')->first()->order - 1;
        }
        
        return ($this->order + $adjacent->order) / 2;
    }
}
