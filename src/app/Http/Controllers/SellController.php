<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\ExhibitionRequest;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SellController extends Controller
{
    public function create()
    {
        $categories = ItemCategory::orderBy('id')->get();
        return view('sell', compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        $data = $request->validated();

        $user = $request->user();

        DB::transaction(function () use ($data, $request, $user) {

            // 画像は storage/app/public/items に保存 → /storage/items/... でアクセス
            $path = $request->file('image')->store('items', 'public');
        

            $item = Item::create([
                'user_id'        => auth()->id(),
                'name'           => $data['name'],
                'brand_name'     => $request->input('brand_name') ?: null,
                'description'    => $data['description'],
                'price'          => $data['price'],
                'status'         => $data['status'], // new / used
                'image_path'     => 'storage/' . $path,   // asset($item->image_path) で表示できる,
                'likes_count'    => 0,
                'comments_count' => 0,
            ]);

            // カテゴリー紐付け（中間テーブル）
            $item->categories()->sync($data['category_ids']);
        });

        return redirect()->route('mypage');
    }
}
