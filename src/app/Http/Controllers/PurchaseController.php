<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseHistory;

class PurchaseController extends Controller
{
    public function create($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = auth()->user();

        $key = "purchase_address.$item_id";
        $address = session($key, [
            'postcode' => $user->postcode,
            'address' => $user->address,
            'building_name' => $user->building_name,
        ]);

        return view('purchase.create', compact('item', 'user', 'address'));
    }

    public function checkout(PurchaseRequest $request, $item_id)
    {
        $data = $request->validated();
        $item = Item::findOrFail($item_id);

        //売り切れチェック（両方共通）
        if ($item->is_sold) {
            abort(403, 'この商品は売り切れています');
        }

        //コンビニ支払い（即購入確定）
        if ($data['payment_method'] === 'convenience') {

            DB::transaction(function () use ($item, $request) {

                // 同時購入防止
            $lockedItem = Item::where('id', $item->id)
                ->lockForUpdate()
                ->first();

                if ($lockedItem->is_sold) {
                abort(403, 'この商品は売り切れています');
                }

                // 購入履歴作成
                PurchaseHistory::create([
                    'user_id' => $request->user()->id,
                    'item_id' => $lockedItem->id,
                    'payment_method' => 'convenience',
                    'status' => 'purchased',
                ]);

                // 商品を売り切れに
                $lockedItem->update([
                    'is_sold' => true,
                ]);
            });

            // トップ画面へ
            return redirect()->route('items.index');
        }


        // カード支払い：Stripeへ
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = CheckoutSession::create([
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => (int) $item->price,
                    'product_data' => [
                        'name' => $item->name,
                    ],
                ],
            ]],
            'success_url' => route('purchase.success', $item_id) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('purchase.cancel', $item_id),
            'metadata' => [
                'item_id'  => (string) $item->id,
                'buyer_id' => (string) auth()->id(),
            ],
        ]);

        return redirect()->away($session->url);
    }

    public function success(Request $request, $item_id)
    {
        $user = $request->user();

        $addr = session("purchase_address.$item_id", [
            'postcode' => $user->postcode,
            'address' => $user->address,
            'building_name' => $user->building_name,
        ]);

        $item = Item::findOrFail($item_id);

        DB::transaction(function () use ($user, $item,$addr) {

            // すでに売り切れなら、二重保存しない
            if ($item->is_sold) { return; }

            PurchaseHistory::firstOrCreate(
                ['user_id' => $user->id, 'item_id' => $item->id],
                [
                    'postcode'       => $addr['postcode'] ?? null,
                    'address'        => $addr['address'] ?? null,
                    'building_name'  => $addr['building_name'] ?? null,
                    'payment_method' => 'card',
                    'status'         => 'purchased',
                ]
            );

            $item->update(['is_sold' => true]);
        });

        session()->forget("purchase_address.$item_id");

        return redirect()->route('mypage', ['tab' => 'purchase']);
    }

    public function cancel($item_id)
    {
        return redirect()->route('purchase.create', $item_id)
            ->with('error', '決済をキャンセルしました');
    }
}
