<?php

namespace App\Http\Controllers;

use App\Models\QueueTicket;
use App\Models\ServiceType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueueTicketController extends Controller
{
    /**
     * Generate a new queue ticket for a given service type.
     * POST /api/tickets
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'service_type_id' => 'required|exists:service_types,id',
        ]);

        $serviceType = ServiceType::findOrFail($request->service_type_id);

        // Use a DB transaction to avoid race conditions on sequence numbers
        $ticket = DB::transaction(function () use ($serviceType) {
            $sequence = $serviceType->nextSequenceNumber();

            return QueueTicket::create([
            'service_type_id' => $serviceType->id,
            'sequence_number' => $sequence,
            'ticket_number' => $serviceType->code . '-' . str_pad($sequence, 3, '0', STR_PAD_LEFT),
            'status' => 'waiting',
            ]);
        });

        return response()->json([
            'message' => 'Ticket generated successfully.',
            'ticket' => $ticket->load('serviceType'),
        ], 201);
    }

    /**
     * List all waiting tickets for a service type (for the display monitor).
     * GET /api/tickets?service_type_id=1
     */
    public function index(Request $request): JsonResponse
    {
        $tickets = QueueTicket::with(['serviceType', 'counter'])
            ->when($request->service_type_id, fn($q) => $q->where('service_type_id', $request->service_type_id))
            ->whereDate('created_at', today())
            ->orderBy('sequence_number')
            ->get();

        return response()->json($tickets);
    }
}
