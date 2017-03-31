<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

Use Log;
use App\Events\CustomerCheckedOutEvent;
use App\Services\TicketService;
use App\Customer;

class NotifyNextVehicle implements ShouldQueue
{

    public $customer;
    private $ticketService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Customer $customer, TicketService $ticketService)
    {
        $this->customer = $customer;
        $this->ticketService = $ticketService;
    }

    /**
     * Handle the event.
     *
     * @param  CustomerCheckedOutEvent  $event
     * @return void
     */
    public function handle(CustomerCheckedOutEvent $event)
    {
        if (!$nextPlate = $this->ticketService->getNextCarInQueue()) {
            Log::debug("No vehicles in queue.");
            return;
        }
        $ticket = $this->ticketService->create($nextPlate);
        Log::debug("NotifyNextVehicle::Listener - Next Car in Queue: {$nextPlate}");
    }
}
