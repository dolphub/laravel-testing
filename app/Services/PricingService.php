<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use App\Ticket;

class PricingService {

    public function getHourlyBalance($ticket) {
        $PRICE_MODEL = Config::get('constants.TICKET_PRICE_MODEL');
        $base = $PRICE_MODEL['BASE'];
        $increments = $PRICE_MODEL['INCREMENTS'];
        $rate = $PRICE_MODEL['RATE'];

        $duration = $ticket->created_at->diffInSeconds($ticket->updated_at);
        $timeIncrement = $increments->search($increments->first(function($val, $key) use ($duration) {
            return $duration < ($val * 3600);
        }));

        return [
            'duration' => $ticket->created_at->diffInMinutes($ticket->updated_at),
            'balance' => $base * pow($rate, $timeIncrement),
        ];
    }
}
