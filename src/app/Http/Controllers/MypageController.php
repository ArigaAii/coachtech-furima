<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Models\Item;
use App\Models\PurchaseHistory;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // 出品一覧：items.user_id で取得
        $listings = Item::where('user_id', $user->id)->latest()->get();

        $purchases = PurchaseHistory::where('user_id', $user->id)
            ->where('status', 'purchased')
            ->with('item')
            ->latest()
            ->get();

        return view('mypage.mypage', compact('user', 'listings','purchases'));
    }

    // /mypage/profile
    public function edit()
    {
        $user = auth()->user();
        return view('mypage.mypage_profile', compact('user'));
    }

    // /mypage/profile (POST)
    public function update(ProfileRequest $request)
    {
        $validated = $request->validated();

        \Log::info('profile update', [
            'hasFile' => $request->hasFile('profile_image'),
            'validated_keys' => array_keys($validated),
        ]);

        $user = $request->user();

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $validated['profile_image'] = $path;
        }

        $user->update($validated);

        if (! $user->profile_completed) {
            $user->profile_completed = true;
            $user->save();
        }

        return redirect()->route('items.index');
    }
}
