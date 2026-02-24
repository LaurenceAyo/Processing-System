<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\ServiceType;

class StaffController extends Controller
{
    /**
     * Staff panel — select your counter.
     * GET /staff
     */
    public function index()
    {
        $counters = Counter::where('is_active', true)->get();
        return view('staff.index', compact('counters'));
    }

    /**
     * Staff panel for a specific counter.
     * GET /staff/{counter}
     */
    public function panel(Counter $counter)
    {
        $serviceTypes  = ServiceType::where('is_active', true)->get();
        $currentTicket = $counter->currentTicket()?->load('serviceType');

        return view('staff.panel', compact('counter', 'serviceTypes', 'currentTicket'));
    }
}