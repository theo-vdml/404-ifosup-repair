<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'title',
        'description',
        'closed_at',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getIsOpenAttribute(): bool
    {
        return is_null($this->closed_at);
    }

    public function getIsClosedAttribute(): bool
    {
        return !is_null($this->closed_at);
    }

    public function close(): void
    {
        $this->closed_at = now();
        $this->save();
    }
}
