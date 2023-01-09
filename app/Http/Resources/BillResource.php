<?php

namespace App\Http\Resources;

use App\Models\Car;
use App\Models\Customer;
use Illuminate\Http\Resources\Json\JsonResource;

class BillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'paymentStatus' => $this->paymentStatus,
            'confirmStatus' => $this->confirmStatus,
            'paymentMethod' => $this->paymentMethod,
            'totalPrice' => number_format($this->totalPrice),
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'car' => $this->getCar($this->carId),
            'customer' => $this->getCustomer($this->customerId),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
    public function getCar($id) {
        return Car::where('id',$id)->first();
    }

    public function getCustomer($id) {
        return Customer::where('id',$id)->first();
    }
}
