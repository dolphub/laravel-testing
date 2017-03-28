<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = "customer";

    // Allows assignments
    protected $fillable = ['plate'];

    protected $visible = ['plate', 'visits'];

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }

    public function getTicket() {
        return $this->tickets()->unpaid();
    }
}
