@extends('layouts.auth')

@section('title', '会員登録')

@section('content')
<div class="page">
    <div class="auth">
        <h1 class="auth__title">会員登録</h1>

        <form class="auth__form" method="POST" action="/register">
            @csrf

            <div class="form-group">
                <label class="form-label">ユーザー名</label>
                <input class="form-input" type="text" name="name" value="{{ old('name') }}">
                @error('name') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">メールアドレス</label>
                <input class="form-input" type="email" name="email" value="{{ old('email') }}">
                @error('email') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">パスワード</label>
                <input class="form-input" type="password" name="password">
                @error('password') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">確認用パスワード</label>
                <input class="form-input" type="password" name="password_confirmation">
            </div>

            <button class="btn btn--primary" type="submit">登録する</button>

            <a class="auth__link" href="{{ url('/login') }}">ログインはこちら</a>
        </form>
    </div>
</div>
@endsection
