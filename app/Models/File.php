<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $timestamp = false;

    protected $fillable = [          
              
        'docs_data',
        'description',   
        'date',        
    ];
}
