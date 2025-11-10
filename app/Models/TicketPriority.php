<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketPriority extends Model
{
    protected $fillable = [
        'code',
        'label',
        'level',
    ];

    protected $casts = [
        'is_builtin' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($priority) {
            // Ensure that built-in priorities cannot be modified
            if ($priority->is_builtin) {
                throw new \Exception('Cannot modify built-in ticket priorities.');
            }
        });

        static::deleting(function ($priority) {
            // Prevent deletion of built-in priorities
            if ($priority->is_builtin) {
                throw new \Exception('Cannot delete built-in ticket priorities.');
            }
        });
    }

    protected static function high(): TicketPriority|null
    {
        return self::where('code', 'high')->first();
    }

    protected static function medium(): TicketPriority|null
    {
        return self::where('code', 'medium')->first();
    }

    protected static function low(): TicketPriority|null
    {
        return self::where('code', 'low')->first();
    }
}
