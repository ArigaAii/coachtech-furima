@extends('layouts.auth')

@section('title', 'メール認証')

@section('content')
<div class="verify-page">
    <div class="verify-card">

        <p class="verify-text">
            登録していただいたメールアドレスに認証メールを送付しました。<br>
            メール認証を完了してください。
        </p>

        {{-- 認証はこちらから（MailHogへ） --}}
        <a class="verify-button" href="http://localhost:8025" target="_blank">
        認証はこちらから
        </a>

        {{-- 認証メール再送 --}}
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <a class="auth__link">認証メールを再送する</a>
        </form>
    </div>
</div>
@endsection