<?php

return [

    'required' => ':attributeを入力してください',
    'email'    => ':attributeはメールアドレス形式で入力してください',

    'min' => [
        'string' => ':attributeは:min文字以上で入力してください',
    ],

    'max' => [
        'string' => ':attributeは:max文字以内で入力してください',
    ],

    'confirmed' => '確認用パスワードが一致していません',

    // フォーム項目の日本語名
    'attributes' => [
        'name'                  => 'ユーザー名',
        'email'                 => 'メールアドレス',
        'password'              => 'パスワード',
        'password_confirmation' => '確認用パスワード',
    ],

];
