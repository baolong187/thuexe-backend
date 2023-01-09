<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $table = 'tblcar';

    protected $fillable = [
        'name',
        'color',
        'licensePlate',
        'seatNumber',
        'price',
        'image64',
        'status',
        'categoryId',
        'branchId'
    ];
}
