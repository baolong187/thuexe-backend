<?php

namespace App\Http\Controllers;

use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Http\Request;
use stdClass;

class CarController extends BaseController
{

    public function index(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : 100;
        $branchId = $request->branchId;
        $categoryId = $request->categoryId;
        $name = $request->name;
        $status = $request->status;
        $seat = $request->seat;

        $car =  Car::when(!empty($branchId), function($query) use($branchId) {
            return $query->where('branchId',$branchId);
        })->when(!empty($categoryId), function($query) use($categoryId) {
            return $query->where('categoryId',$categoryId);
        })->when(!empty($seat), function($query) use($seat) {
            return $query->where('seatNumber',$seat);
        })->when(!empty($name), function($query) use($name) {
            return $query->where('name','LIKE', "%{$name}%");
        })->when(!empty($status), function($query) use($status) {
            return $query->where('status',$status);
        })->orderBy('created_at','DESC')->paginate($limit); 

        return $this->response(CarResource::collection($car));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $car = new Car();
        $car->name = $request->name;
        $car->color = $request->color;
        $car->licensePlate = $request->licensePlate;
        $car->seatNumber = $request->seatNumber;
        $car->price = $request->price;
        $car->image64= $request->image64;
        $car->status="A";
        $car->categoryId=$request->categoryId;
        $car->branchId=$request->branchId;
        if($car->save()) {
            return $this->response(new stdClass);
        }
        return $this->response(new stdClass, 'create failed', 1, 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        $car = Car::where('id',$request->id)->first();
        return $this->response(new CarResource($car));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $car = Car::where('id', $request->id)->first();
        $car->status = $request->status;
        $car->save();
        return $this->response(new CarResource($car));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function getFirstCar(Request $request)
    {
        //
        $categoryId = $request->categoryId;
        if($request->seat && $request->seat > 4) {
            $seat = 7;
        }
        else{
            $seat = 4;
        }
        $car =  Car::when(!empty($categoryId), function($query) use($categoryId) {
            return $query->where('categoryId',$categoryId);
        })->when(!empty($seat), function($query) use($seat) {
            return $query->where('seatNumber',$seat);
        })->where('status','A')->first();
        if($car) {
            return $this->response(new CarResource($car));
        }
        return $this->response(new stdClass);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        //
    }
}
