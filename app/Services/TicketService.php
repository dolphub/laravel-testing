<?php

namespace App\Services;

use App\Services\PricingService;
use App\Customer;
use App\Ticket;

class TicketService {

    public function __construct(PricingService $priceService) {
        $this->priceService = $priceService;
    }

    public function create($plate_number) {
        $customer = Customer::firstOrCreate(['plate' => $plate_number]);
        $ticket = Ticket::create(['customer_id' => $customer->id ]);
        $customer->checked_in = true;
        $customer->save();

        return [ 'ticket' => $ticket->id,
            'issue_timestamp' => $ticket->created_at,
            'plate' => $customer->plate,
        ];
    }

    public function hasCapacity() {
        return Customer::where('checked_in', true)->count() < config('app.garage_capacity');
    }

    /**
     * @param {String} - Customer Plate Number
     */
    public function getUnpaidTicket($plate_number) {
        if (!$customer = Customer::where('plate', $plate_number)->first()) {
            return false;
        }
        return $customer->getTicket();
    }

    public function getTicketBalance($ticket) {
        return $this->priceService->getBalance($ticket);
    }

    public function payTicket($ticket) {
        $balance = $this->priceService->getBalance($ticket);
        // Assume some kind of transaction here
        $ticket->paid = true;
        $ticket->save();
        return $ticket->id;
    }

    public function insertCustomerIntoQueue($plate_number) {
        // TODO: Not yet implemented
        return 1;
    }
}
