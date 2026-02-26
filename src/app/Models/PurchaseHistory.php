<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class PurchaseHistory extends Model
{
    protected $table = 'purchase_histories';

    protected $fillable = [
        'user_id',
        'item_id',
        'postcode',
        'address',
        'building_name',
        'payment_method',
        'status',
    ];
    
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    //use HasFactory;

    //protected $fillable = ['user_id','item_id','postcode', 'address','building_name','payment_method','status',];
}
