@extends('layouts.auth')

@section('title', 'ログイン')

@section('content')
<div class="page">
    <div class="auth">
        <h1 class="auth__title">ログイン</h1>

        <form class="auth__form" method="POST" action="/login">
            @csrf

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

            <button class="btn btn--primary" type="submit">ログインする</button>

            <a class="auth__link" href="{{ url('/register') }}">会員登録はこちら</a>
        </form>
    </div>
</div>
@endsection

