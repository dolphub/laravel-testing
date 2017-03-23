<?php

use Illuminate\Http\Request;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TicketController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('customers/{id}', 'CustomerController@getUserById');
Route::get('customers', 'CustomerController@getAllUsers');
Route::get('customers/{id}/tickets', 'CustomerController@getAllTicketsByCustomerId');

Route::get('tickets/{id}', 'TicketController@getBalance');
Route::post('tickets', 'TicketController@generateTicket');
