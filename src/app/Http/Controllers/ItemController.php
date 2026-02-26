<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend');
        $keyword = $request->query('keyword');

        $query = Item::query();
        
        //自分のid以外を表示（ログイン時のみ）
        if (auth()->check()) {
            $query->where('user_id', '!=', auth()->id());
        }

        //キーワード検索
        if ($keyword) {
            $query->where('name', 'like', "%{$keyword}%");
        }

        //マイリスト（いいねした商品だけ）
        if ($tab === 'mylist') {
            if (!auth()->check()) {
                $items = collect();
                return view('items.index', compact('items', 'keyword', 'tab'));
            }

            $query->whereIn('id', function ($q) {
                $q->from('likes')
                  ->select('item_id')
                  ->where('user_id', auth()->id());
            });
        }

        $items = $query->orderByDesc('id')->get();

        return view('items.index', compact('items', 'keyword', 'tab'));
    }

    public function show($item_id)
    {
        $item = Item::with([
            'comments' => function ($query) {$query->latest();},
            'comments.user',
            'categories'
        ])->findOrFail($item_id);

        return view('items.show', compact('item'));
    }
}
