<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Log;

use App\Customer;

class CustomerController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getUserById(Customer $customer, Request $request) {
        return response()->json($customer, 200);
    }

    public function getAllUsers(Request $request) {
        return response()->json([ 'customers' => Customer::all() ], 200);
    }

    public function getAllTicketsByCustomerId(Customer $customer, Request $request) {
        $tickets = $customer->unpaidTickets();
        return response()->json([ 'Tickets' => $tickets ], 200);
    }
}
