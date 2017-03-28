<?php

namespace App\Validators;

use App\Customer;

class TicketValidator
{
    /**
     * Checks to see if there are unpaid tickets with this plate id
     *
     * returns {Boolean} - Returns false if there are unpaid tickets found
     */
    public function plateNoOutstandingTickets($attribute, $value, $parameters, $validator) {
        if (!$customer = Customer::where('plate', $value)->first()) {
            return true;
        }
        return !$customer->tickets->where('paid', 0)->first()->exists();
    }
}
