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
        $messages = [
            'plate.required' => 'Please provide a plate number',
            'plate.plate_no_outstanding_tickets' => 'You have an outstanding ticket',
        ];
        $rules = [
            'plate' => [ 'required|plate_no_outstanding_tickets' ],
        ];
        $this->validate($request, $rules, $messages);
        $plate = $request->get('plate');

        if (!$this->service->hasCapacity()) {
            // TODO: Update message to show queue number when implemented
            $queueNumber = $this->service->insertCustomerIntoQueue($plate);
            return response()->json([ 'errors' =>
                "Garage Currently Full. Your Position in Queue is {$queueNumber}."], 422);
        }

        $ticket = $this->service->create($plate);
        return response()->json($ticket, 200);
    }

    public function getBalance(Ticket $ticket, Request $request) {
        $balance = $this->service->getTicketBalance($ticket);
        return response()->json([ 'balance' => $balance ], 200);
    }

    public function payTicket(Ticket $ticket, Request $request) {
        // if ($this->service->)
        // $this->service->payTicket($ticketId);
        return response()->json($ticket->created_at, 422);
    }
}
