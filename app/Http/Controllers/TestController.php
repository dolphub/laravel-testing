<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Customer;


class TestController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getUserId($id, Request $request) {
        if (!is_numeric($id)) {
            
        }

        return response()->json($responseArray, 200);
    }

    public function getAllUsers(Request $request) {
        // TODO: Return all users
        return response()->json([ 'users' => Customer::all() ], 200);
    }
}
