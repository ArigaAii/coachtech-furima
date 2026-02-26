<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $item_id)
    {
        dd($request->all());

        // バリデーション
        $request->validate([
            'body' => ['required', 'string', 'max:255'],
        ]);
        // 商品が存在するか確認
        $item = Item::findOrFail($item_id);

        // コメント保存
        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'body'    => $request->body,
        ]);

        //　商品詳細画面に戻る
        return redirect()->route('items.show', ['item_id' => $item->id]);
    }
}
