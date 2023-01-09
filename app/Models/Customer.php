<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'tblcustomer';

    protected $fillable = [
        'fullname',
        'identityCard',
        'telephone',
        'address',
        'username',
        'password',
        'email'
    ];
}
