<?php

namespace App\Jobs;

use App\Models\Bill;
use App\Models\Car;
use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;
    public $bill;
    public $car;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($bill, $car)
    {
        //
        $this->bill = $bill;
        $this->car = $car;        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customer = Customer::where('id',$this->bill->customerId)->first();
        $details = [
            'title' => 'Hóa đơn chờ duyệt',
            'body' => $this->car->name
        ];
        Mail::to($customer->email)->send(new \App\Mail\SendMail($details,$this->bill, $this->car));    
    }
}
