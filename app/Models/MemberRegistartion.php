<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberRegistartion extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $timestamp = false;

    protected $fillable = [                
        'first_name',
        'second_name',
        'maiden_name',
        'email',        
        'phone',        
        'id_number',
        'member_location',
        'service_number',
        'spouse_name',        
        'spouse_maiden_name',
        'class',
        'id_card',
        'passport_photo',
        'marriage_cert',
        
    ];

    // public function sections()
    // {
    //     return $this->hasMany(County::class);
    // }

}