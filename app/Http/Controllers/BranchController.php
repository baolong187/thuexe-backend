<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use stdClass;

class BranchController extends BaseController
{
    
    public function index(Request $request)
    {
        $branch = Branch::all();
        return $this->response($branch);
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
        $brand = new Branch();
        $brand->name = $request->name;
        if($brand->save()) {
            return $this->response(new stdClass);
        }
        return $this->response(new stdClass, 'failed', 1, 400);
    }

    
    public function show(Branch $branch)
    {
        //
    }

   
    public function edit(Branch $branch)
    {
        //
    }

   
    public function update(Request $request, Branch $branch)
    {
        //
    }

   
    public function destroy(Branch $branch)
    {
        //
    }
}
