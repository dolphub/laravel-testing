<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;
use App\Services\PricingService;
use App\Customer;
use App\Ticket;

class TicketService {

    public static $QUEUE_KEY = 'parking_queue';
    public static $SET_KEY = 'parking_set';

    public function __construct(PricingService $priceService, Redis $redis) {
        $this->priceService = $priceService;
        $this->redis = $redis;
    }

    public function create($plate_number) {
        $customer = Customer::firstOrCreate(['plate' => $plate_number]);
        $ticket = Ticket::create(['customer_id' => $customer->id ]);
        $customer->checked_in = true;
        $customer->visits++;
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
        $ticket->customer->checked_in = false;
        $ticket->customer->save();
        $ticket->saveOrFail();
        return $ticket->id;
    }

    public function insertCustomerIntoQueue($plate_number) {
        if (Redis::sismember(self::$SET_KEY, $plate_number)) {
            return -1;
        }
        Redis::multi();
        Redis::rpush(self::$QUEUE_KEY, $plate_number);
        Redis::sadd(self::$SET_KEY, $plate_number);
        Redis::exec();
        return Redis::llen(self::$QUEUE_KEY);
    }

    public function getNextCarInQueue() {
        if (!Redis::llen(self::$QUEUE_KEY)) {
            return null;
        }
        $plate = Redis::lpop(self::$QUEUE_KEY);
        Redis::srem(self::$SET_KEY, $plate);
        return $plate;
    }
}
