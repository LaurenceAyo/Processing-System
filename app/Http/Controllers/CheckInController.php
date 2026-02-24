<?php

namespace App\Http\Controllers;

use App\Models\QueueTicket;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CheckInController extends Controller
{
    /**
     * Show the printable QR code page for a service type.
     *  GET /qr/{serviceType}
     */
    public function showQr(ServiceType $serviceType)
    {
        $url = url("/checkin/{$serviceType->id}");
        $qrCode = QrCode::format('svg')->size(300)->generate($url);

        return view('checkin.qr', compact('serviceType', 'qrCode', 'url'));
    }

    /**
     * Confirmation page — shown immediately after scanning.
     * GET /checkin/{serviceType}
     */
    public function showCheckIn(ServiceType $serviceType)
    {
        return view('checkin.confirm', compact('serviceType'));
    }

    /**
     * Actually create the ticket — called when user taps "Get My Ticket".
     * POST /checkin/{serviceType}
     */
    public function createTicket(ServiceType $serviceType)
    {
        $ticket = DB::transaction(function () use ($serviceType) {
            $sequence = $serviceType->nextSequenceNumber();

            return QueueTicket::create([
            'service_type_id' => $serviceType->id,
            'sequence_number' => $sequence,
            'ticket_number' => $serviceType->code . '-' . str_pad($sequence, 3, '0', STR_PAD_LEFT),
            'status' => 'waiting',
            ]);
        });

        // Redirect to a safe result page — reloading won't create another ticket
        return redirect()->route('checkin.ticket', $ticket->id);
    }

    /**
     * Show the generated ticket (safe to reload).
     * GET /checkin/ticket/{ticket}
     */
    public function showTicket(QueueTicket $ticket)
    {
        $serviceType = $ticket->serviceType;

        $ahead = QueueTicket::where('service_type_id', $serviceType->id)
            ->whereDate('created_at', today())
            ->where('status', 'waiting')
            ->where('sequence_number', '<', $ticket->sequence_number)
            ->count();

        return view('checkin.ticket', compact('ticket', 'serviceType', 'ahead'));
    }

    /**
     * Page listing all QR codes (for office admin to print).
     *  GET /qr
     */
    public function index()
    {
        $serviceTypes = ServiceType::where('is_active', true)->get();
        return view('checkin.index', compact('serviceTypes'));
    }
}
