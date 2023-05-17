<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    //Mass Assignment
    protected $fillable = [
        'amount',
        'date',
        'card_type',
        'cardholder_name',
        'card_number',
        'card_expiration',
        'card_cvv'
    ];
}
