<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->belongsToMany(
            \App\Models\Item::class,
            'item_item_categories',
            'item_category_id',
            'item_id'
        );
    }
}
