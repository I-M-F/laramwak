<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mwak_reg extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $timestamp = false;

    protected $fillable = [

        'member_id',
        'phone',
        'email',
        'description',
        'date',
    ];
}
