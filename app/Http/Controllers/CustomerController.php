<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Customer;

class CustomerController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getUserById($id, Request $request) {
        // $this->validate($request, [
        //     'ts' => 'required'
        // ]);

        if ( !$customer = Customer::find($id)) {
            return response()->json([ "error" => "Customer not found."], 404);
        }
        return response()->json($customer, 200);
    }

    public function getAllUsers(Request $request) {
        return response()->json([ 'customers' => Customer::all() ], 200);
    }

    public function getAllTicketsByCustomerId($customer_id, Request $request) {
        $tickets = Customer::find($customer_id)->tickets()->get();
        return response()->json([ 'Tickets' => $tickets ], 200);
    }
}
