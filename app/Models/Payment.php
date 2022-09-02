<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $timestamp = false;

    protected $fillable = [                
        'payment_description',     
        'phone',        
        'amount',        
        'tx_number',
        'status',   
        'date',        
    ];
}
