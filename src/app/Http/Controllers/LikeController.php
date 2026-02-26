<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Item;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Request $request, Item $item)
    {
        $user = $request->user();
        $exists = Like::where('user_id', $user->id)
            ->where('item_id', $item->id)
            ->exists();

        if ($exists) {
            Like::where('user_id', $user->id)
                ->where('item_id', $item->id)
                ->delete();

            if (($item->likes_count ?? 0) > 0) {
                $item->decrement('likes_count');
            }
        } else {
            Like::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
            ]);

            $item->increment('likes_count');
        }

        return back();
    }
}
