<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $table = 'tblbill';

    protected $fillable = [
        'paymentStatus',
        'confirmStatus',
        'paymentMethod',
        'totalPrice',
        'startDate',
        'endDate',
        'employeeId',
        'carId',
        'customerId'
    ];
}
