<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';
    protected $fillable = ['customer_id'];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    // Naming conventions mean shit
    public function scopeUnpaid($query) {
        return $query->where('paid', false);
    }
}
