<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceType extends Model
{
    protected $fillable = ['name', 'code', 'description', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function queueTickets(): HasMany
    {
        return $this->hasMany(QueueTicket::class);
    }

    /**
     * Get the next sequence number for this service type (today only).
     */
    public function nextSequenceNumber(): int
    {
        $last = $this->queueTickets()
            ->whereDate('created_at', today())
            ->max('sequence_number');

        return ($last ?? 0) + 1;
    }
}
