<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use stdClass;

class CustomerController extends BaseController
{
    public function login(Request $request) 
    {
        $customer = Customer::where('username', $request->username)->where('password', $request->password)->first();
        if(!$customer) {
            return $this->response(new stdClass, 'No result', 1 ,200);
        }
        return $this->response($customer);
    }
    public function register(Request $request)
    {
        $customer = Customer::where(function ($query) use ($request) {
            $query->where('telephone',$request->telephone)->orWhere('identityCard',$request->identityCard)->orWhere('username',$request->username);
        })->first();
        if($customer) {
            return $this->response($customer, 'User already exist', 2 ,400);
        }
        $customer = new Customer();
        $customer->fullname = $request->fullname;
        $customer->identityCard = $request->identityCard;
        $customer->telephone = $request->telephone;
        $customer->address = $request->address;
        $customer->username = $request->username;
        $customer->password = $request->password;
        $customer->email = $request->email;
        $customer->save();
        return $this->response($customer);
    }
}
