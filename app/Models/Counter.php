<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Counter extends Model
{
    protected $fillable = ['name', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function queueTickets(): HasMany
    {
        return $this->hasMany(QueueTicket::class);
    }

    /**
     * Get the ticket currently being served at this counter.
     */
    public function currentTicket(): ?QueueTicket
    {
        return $this->queueTickets()
            ->where('status', 'serving')
            ->latest('called_at')
            ->first();
    }
}
