<?php

namespace App\Services

use App\Customer;

class CustomerService {

    public function create($request) {
        $customer = Customer::firstOrCreate(['plate' => $request->get('plate')]);

        // Don't issue tickets to customers who have outstanding balances
        if ($unpaidTicket = $customer->hasUnpaidTicket()) { // Check for outstanding balances
            return response()->json(['errors' => 'Outstanding ticket', 'ticket_number' => $unpaidTicket->id], 422);
        }

        if ($this->checkCapacity() >= config('app.garage_capacity')) {
            // TODO: Insert into message queue for notification
            return response()->json([ 'errors' => 'Garage is at capacity' ], 422);
        }

        $ticket = Ticket::create(['customer_id' => $customer->id ]);
        $customer->checked_in = true;
        $customer->save();
        return [ 'ticket' => $ticket->id,
            'issue_timestamp' => $ticket->created_at,
            'plate' => $customer->plate
        ];
    }

    private function checkCapacity() {
        return Customer::where('checked_in', true)->count();
    }
}
