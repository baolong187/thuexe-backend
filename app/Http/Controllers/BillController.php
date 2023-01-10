<?php

namespace App\Http\Controllers;

use App\Http\Resources\BillResource;
use App\Jobs\SendBillUpdate;
use App\Jobs\SendMail;
use App\Models\Bill;
use App\Models\Car;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use stdClass;

class BillController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = isset($request->status) ? $request->status : '';
        $sd = $request->sd;
        $ed = $request->ed;
        $carId = $request->carId;

        if(isset($request->phone))
        {
            $phone = $request->phone;
            $customer = Customer::where('telephone',$phone)->first();
            $bill = Bill::where(function ($query) use ($status) {
                return $query->where('confirmStatus','like', '%'. $status.'%');
            })->when(!empty($customer), function($query) use($customer) {
                return $query->where('customerId',$customer->id);
            })->orderBy('created_at','DESC')->get();
        }
        else
        {
            $bill = Bill::where(function ($query) use ($status) {
                return $query->where('confirmStatus','like', '%'. $status.'%');
            })->when(!empty($request->sd), function($query) use($sd) {
                return $query->whereDate('startDate','>=',$sd);
            })->when(!empty($ed), function($query) use($ed) {
                return $query->whereDate('endDate','<=',$ed);
            })->when(!empty($carId), function($query) use($carId){
                return $query->where('carId',$carId);
            })->orderBy('created_at','DESC')->get();
        }
        return $this->response(BillResource::collection($bill));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $bill = Bill::where("id",$request->id)->first();
        $bill->paymentStatus = $request->paymentStatus;
        $bill->confirmStatus = $request->confirmStatus;
        $bill->save();
        if($bill->paymentStatus == "paid" && $bill->confirmStatus == 'confirm') {
            dispatch(new SendBillUpdate($bill)); 
        }
        return $this->response(new BillResource($bill));
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
        $bill = new Bill();
        $car = Car::where('id',$request->carId)->first();
        if($car->status == 'IA') {
            return $this->response(new stdClass, 'Car is already booked', 1);
        }
        $bill->paymentStatus = $request->paymentStatus;
        $bill->confirmStatus = $request->confirmStatus;
        $bill->paymentMethod = $request->paymentMethod;
        $bill->totalPrice = $request->totalPrice;
        $bill->startDate = $request->startDate;
        $bill->endDate = $request->endDate;
        $bill->carId = $request->carId;
        $bill->customerId = $request->customerId;
        $bill->save();
        $car->status = "IA";
        $car->save();
        dispatch(new SendMail($bill,$car));
        return $this->response(new BillResource($bill));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        if(isset($request->customerId)) {
            $bill = Bill::where('id', $request->id)->where('customerId', $request->customerId)->first();
        }
        else {
            $bill = Bill::where('id', $request->id)->first();
        }
        if($bill) {
            return $this->response(new BillResource($bill));
        }
        return $this->response(new stdClass, 'No result', 1, 400);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function summary() {
        $car = Car::all()->count();
        $customer = Customer::all()->count();
        $bill = Bill::where('confirmStatus','pending')->count();
        $revenue = Bill::sum('totalPrice');
        $summary = collect([
            [
                'car' => $car, 
                'customer' => $customer,
                'bill' => $bill,
                'revenue' => number_format($revenue)
            ],
        ]);
        return $this->response($summary[0]);
    }

    public function recentBill() {
        $bill = Bill::orderBy('created_at', 'DESC')->take(5)->get();
        if($bill) {
            return $this->response( BillResource::collection($bill));
        }
        return $this->response(new stdClass, 'No result', 1, 400);
    }

    public function revenueByCar() {
        $bills = Bill::select("carId")->selectRaw("SUM(totalPrice) as total_pirce")->groupBy('carId')->orderBy('total_pirce','DESC')->take(5)->get();
        foreach($bills as $bill) {
            $car = Car::where('id',$bill->carId)->select("name","licensePlate")->first();
            $bill->car_name = $car->name;
            $bill->licensePlate = $car->licensePlate;
        }
        return $this->response($bills);
    }

    public function revenueByMonth() {
        $bills = Bill::selectRaw("SUM(totalPrice) as total_pirce")
                        ->selectRaw("MIN(DATE_FORMAT(created_at, '%m-%Y')) as new_date, 
                                    YEAR(created_at) AS year, 
                                    MONTH(created_at) AS month")
                        ->groupBy('year','month')
                        ->get();
        return $bills;
    }
}
