<?php

namespace App\Http\Resources;

use App\Models\Bill;
use App\Models\Branch;
use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
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
            'name' => $this->name,
            'color' => $this->color,
            'licensePlate' => $this->licensePlate,
            'seatNumber' => $this->seatNumber,
            'price' => $this->price,
            'image64' => $this->image64,
            'status' => $this->status,
            'category' => $this->category($this->categoryId),
            'branch' => $this->branch($this->branchId),
            'revenue' => $this->getRevenue($this->id),
        ];
    }

    public function category($categoryId) {
        return Category::where('id',$categoryId)->first()->name;
    }

    public function branch($branchId) {
        return Branch::where('id',$branchId)->first()->name;
    }
    
    public function getRevenue($id) {
        return Bill::where('carId', $id)->sum('totalPrice');
    }
}
