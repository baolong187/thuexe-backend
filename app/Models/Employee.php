<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'tblemployee';

    protected $fillable = [
        'fullname',
        'telephone',
        'position',
        'address',
        'salary',
        'username',
        'password',
    ];
}
