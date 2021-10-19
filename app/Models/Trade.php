<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;
    protected $fillable = [
        'symbol',
        'side',
        'price',
        'amount',
        'cost',
        'fee',
        'fee_currency'
    ];
}
