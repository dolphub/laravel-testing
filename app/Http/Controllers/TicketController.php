<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Services\TicketService;

use App\Customer;
use App\Ticket;

class TicketController extends Controller
{
    protected $service;

    public function __construct(TicketService $ticketService) {
        $this->service = $ticketService;
    }

    public function generateTicket(Request $request) {
        $this->validate($request, [ 'plate' => 'required' ]);
        $plate = $request->get('plate');

        if ($this->service->hasUnpaidTicket($plate)) {
            return response()->json([ 'errors' => 'Outstanding Ticket' ], 422);
        }

        if (!$this->service->hasCapacity()) {
            // TODO: Insert into message queue for notification
            return response()->json([ 'errors' => 'Garage is at capacity'], 422);
        }

        $ticket = $this->service->create($plate);
        return response()->json($ticket, 200);
    }

    public function getBalance($ticketId, Request $request) {
        if (!$balance = $this->service->getBalance($ticketId)) {
            return response()->json(['errors' => 'Ticket not found'], 422);
        }
        return response()->json([ 'balance' => $balance], 200);
    }
}
