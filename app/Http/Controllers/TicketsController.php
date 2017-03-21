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

class TicketsController extends Controller
{
    public function generateTicket(Request $request, TicketService $ticketService) {
        $this->validate($request, [ 'plate' => 'required' ]);
        $response = $ticketService->create($request);
        return response()->json($response, 200);
    }

    private function checkCapacity() {
        return Customer::where('checked_in', true)->count();
    }

    public function getTicketById($ticket_id, Request $request) {
        $ticket = Ticket::find($ticket_id);
        return response()->json(['ticket' => $ticket], 200);
    }
}
