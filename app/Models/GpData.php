<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GpData extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'id_card',
        'full_name',
        'date_of_birth',
        'age',
        'gender',
        'native_place',
        'address',
        'address1',
        'religion',
        'edu_level',
        'career', 
    ];
}
