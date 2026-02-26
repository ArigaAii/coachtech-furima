<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;

class PurchaseAddressController extends Controller
{
    public function edit(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = $request->user();

        $key = "purchase_address.$item_id";
        $address = session($key, [
            'postcode' => $user->postcode,
            'address' => $user->address,
            'building_name' => $user->building_name,
        ]);

        return view('purchase.address_edit', compact('item', 'address'));
    }

    public function update(AddressRequest $request, $item_id)
    {
        Item::findOrFail($item_id);

        $data = $request->validated();

        session(["purchase_address.$item_id" => $data]);

        // 購入画面に戻す
        return redirect()->route('purchase.create', $item_id)
            ->with('success', '配送先を更新しました');
    }
}
