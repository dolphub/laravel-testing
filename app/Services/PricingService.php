<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use App\Ticket;

class PricingService {

    public function getBalance($ticket) {
        $PRICE_MODEL = Config::get('constants.TICKET_PRICE_MODEL');
        $base = $PRICE_MODEL['BASE'];
        $increments = $PRICE_MODEL['INCREMENTS'];
        $rate = $PRICE_MODEL['RATE'];

        $ticket->touch(); // Update updated_at for calculation
        $duration = $ticket->created_at->diffInSeconds($ticket->updated_at);
        $timeIncrement = $increments->search($increments->first(function($val, $key) use ($duration) {
            return $duration < ($val * 3600);
        }));

        return $base * pow($rate, $timeIncrement);
    }
}
