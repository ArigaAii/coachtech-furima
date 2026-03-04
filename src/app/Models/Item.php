<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'price',
        'description',
        'brand_name',
        'status',
        'image_path',
        'likes_count',
        'comments_count',
        'is_sold',
    ];

    protected $casts = [
        'is_sold' => 'boolean',
    ];

    public function likes()
    {
        return $this->hasMany(\App\Models\Like::class);
    }

    public function isLikedBy(?\App\Models\User $user): bool
    {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function categories()
    {
        return $this->belongsToMany(
            \App\Models\ItemCategory::class,
            'item_item_categories',
            'item_id',
            'item_category_id'
        );
    }

    public function getStatusLabelAttribute()
    {
    return [
        'new'  => '新品',
        'good' => '目立った傷や汚れなし',
        'used' => 'やや傷や汚れあり',
        'bad'  => '状態が悪い',
    ][$this->status] ?? $this->status; 
    // 日本語データが入っている場合はそのまま返す
    }


}
