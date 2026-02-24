<?php

namespace App\Http\Controllers;

use App\Events\QueueUpdated;
use App\Models\Counter;
use App\Models\QueueTicket;
use Illuminate\Http\JsonResponse;

class CounterController extends Controller
{
    /**
     * List all active counters.
     * GET /api/counters
     */
    public function index(): JsonResponse
    {
        $counters = Counter::where('is_active', true)
            ->with(['queueTickets' => fn($q) => $q->where('status', 'serving')])
            ->get()
            ->map(function ($counter) {
            return [
            'id' => $counter->id,
            'name' => $counter->name,
            'current_ticket' => $counter->currentTicket(),
            ];
        });

        return response()->json($counters);
    }

    /**
     * Call the next waiting ticket to this counter.
     * POST /api/counters/{counter}/next
     */
    public function next(Counter $counter): JsonResponse
    {
        // Mark any currently serving ticket as done first
        QueueTicket::where('counter_id', $counter->id)
            ->where('status', 'serving')
            ->update(['status' => 'done', 'served_at' => now()]);

        // Get the oldest waiting ticket
        $next = QueueTicket::where('status', 'waiting')
            ->whereDate('created_at', today())
            ->orderBy('sequence_number')
            ->first();

        if (!$next) {
            broadcast(new QueueUpdated('next', null, $counter->id, $counter->name))->toOthers();
            return response()->json(['message' => 'No more tickets in the queue.'], 200);
        }

        $next->update([
            'status' => 'serving',
            'counter_id' => $counter->id,
            'called_at' => now(),
        ]);

        $next->load('serviceType', 'counter');

        broadcast(new QueueUpdated('next', $next, $counter->id, $counter->name));

        return response()->json([
            'message' => 'Now serving ticket.',
            'ticket' => $next,
        ]);
    }

    /**
     * Skip the current ticket at this counter.
     * POST /api/counters/{counter}/skip
     */
    public function skip(Counter $counter): JsonResponse
    {
        $current = $counter->currentTicket();

        if (!$current) {
            return response()->json(['message' => 'No ticket is currently being served.'], 404);
        }

        $current->update(['status' => 'skipped']);
        $current->load('serviceType');

        broadcast(new QueueUpdated('skip', $current, $counter->id, $counter->name));

        return response()->json([
            'message' => 'Ticket skipped.',
            'ticket' => $current,
        ]);
    }

    /**
     * Recall (re-announce) the current ticket at this counter.
     * POST /api/counters/{counter}/recall
     */
    public function recall(Counter $counter): JsonResponse
    {
        $current = $counter->currentTicket();

        if (!$current) {
            return response()->json(['message' => 'No ticket is currently being served.'], 404);
        }

        $current->update(['called_at' => now()]);
        $current->load('serviceType', 'counter');

        broadcast(new QueueUpdated('recall', $current, $counter->id, $counter->name));

        return response()->json([
            'message' => 'Ticket recalled.',
            'ticket' => $current,
        ]);
    }
}
