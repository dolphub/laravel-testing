<?php

namespace App\Listeners;

use App\Events\CustomerCheckedOutEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailReceipt implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CustomerCheckedOutEvent  $event
     * @return void
     */
    public function handle(CustomerCheckedOutEvent $event)
    {
        \Log::debug('SendEmailReceipt::Listener hit');
    }
}
