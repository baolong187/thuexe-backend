<?php

namespace App\Jobs;

use App\Models\Car;
use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBillUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;
    public $bill;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($bill)
    {
        //
        $this->bill = $bill;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $customer = Customer::where('id',$this->bill->customerId)->first();
        $car = Car::where('id',$this->bill->carId)->first();
        $details = [
            'title' => 'Hóa đơn được duyệt',
        ];
        Mail::to($customer->email)->send(new \App\Mail\SendMail($details,$this->bill, $car)); 
    }
}
