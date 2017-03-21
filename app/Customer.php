<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = "customers";

    // Allows assignments
    protected $fillable = ['plate'];

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }

    public function hasUnpaidTicket() {
        return $this->tickets()->unpaid()->first();
    }
}
