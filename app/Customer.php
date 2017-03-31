<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = "customer";

    // Allows assignments
    protected $fillable = ['plate'];

    protected $visible = ['plate', 'visits', 'checked_in'];

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }

    public function scopeUnpaidTickets($query) {
        return $this->tickets->where('paid', 0);
    }
}
