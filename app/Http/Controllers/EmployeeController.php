<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use stdClass;

class EmployeeController extends BaseController
{
    public function login(Request $request) 
    {
        $employee = Employee::where('username', $request->username)->first();
        if(!$employee) {
            return $this->response(new stdClass, 'No result', 1 ,200);
        }
        if(Hash::check($request->password, $employee->password)) {
            return $this->response($employee);
        }
        return $this->response(new stdClass, 'wrong password',2,400);
    }
}
