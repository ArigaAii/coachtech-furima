<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'postcode',
        'address',
        'building_name',
        'payment_method',
        'status',
    ];

    protected $table = 'purchase_histories';


}
