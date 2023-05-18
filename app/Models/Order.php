<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    //Mass assigment
    protected $fillable = [
        'date',
        'status',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'postal_code'
    ];
    public $timestamps = false; //ignora i "timestamps"
}
