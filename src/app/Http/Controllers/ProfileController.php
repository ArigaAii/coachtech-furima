<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('mypage.profile', [
            'user' => $request->user(),
        ]);
    }

    //プロフィール更新
    public function update(Request $request)
    {
        $user = $request->user();

        // バリデーション
        $validated = $request->validate([
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png'],
            'name'          => ['required', 'string', 'max:20'],
            'postcode'      => ['nullable', 'regex:/^\d{3}-?\d{4}$/'],
            'address'       => ['nullable', 'string'],
            'building_name' => ['nullable', 'string'],
        ]);

        // 画像保存
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')
                            ->store('profiles', 'public');
            $validated['profile_image'] = $path;
        }

        //プロフィール保存
        $user->update($validated);

        //初回プロフィール完了
       if (!$user->profile_completed) {
            $user->profile_completed = true;
            $user->save();
        }

        //初回でも通常でも自然な遷移
        return redirect('/');
    }
}
