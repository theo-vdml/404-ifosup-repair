<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketStatus extends Model
{
    protected $table = 'ticket_statuses';

    protected $fillable = [
        'code',
        'label',
        'color',
        'icon',
        'marks_as_closed',
    ];

    protected $casts = [
        'is_builtin' => 'boolean',
        'marks_as_closed' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($status) {
            // Ensure that built-in statuses cannot be modified
            if ($status->is_builtin && ($status->isDirty('code') || $status->isDirty('marks_as_closed') || $status->isDirty('is_builtin'))) {
                throw new \Exception('Cannot modify built-in ticket statuses.');
            }
        });

        static::deleting(function ($status) {
            // Prevent deletion of built-in statuses
            if ($status->is_builtin) {
                throw new \Exception('Cannot delete built-in ticket statuses.');
            }
        });
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->label ?? ucfirst($this->code);
    }

    /**
     * Retrieve the built-in "open" status.
     */
    public static function open(): TicketStatus|null
    {
        return self::where('code', 'open')->first();
    }

    /**
     * Retrieve the built-in "closed" status.
     */
    public static function closed(): TicketStatus|null
    {
        return self::where('code', 'closed')->first();
    }

    public static function closedUncompleted(): TicketStatus|null
    {
        return self::where('code', 'closed_uncompleted')->first();
    }

    public static function getSelectOptions(): array
    {
        return self::orderBy('label')->get()->mapWithKeys(function ($status) {
            return [$status->code => $status->display_name];
        })->toArray();
    }
}
