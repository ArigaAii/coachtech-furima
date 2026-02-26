<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\CommentRequest;

class ItemCommentController extends Controller
{
    public function store(CommentRequest $request, Item $item)
    {
        $data = $request->validated();

        $item->comments()->create([
            'user_id' => $request->user()->id,
            'body'    => $data['body'],
        ]);

        return redirect()->route('items.show', ['item_id' => $item->id]);
    }
}
