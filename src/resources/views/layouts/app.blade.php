<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'COACHTECH FURIMA')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('css')
</head>
<body>
<header class="header">
    <div class="header__inner">
        <a class="header__logo" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="COACHTECH">
        </a>

        <form class="header__search" method="GET" action="{{ url('/') }}">
            <input
                class="header__searchInput"
                type="text"
                name="keyword"
                value="{{ request('keyword') }}"
                placeholder="なにをお探しですか？"
            >
        </form>

        <nav class="header__nav">
            @guest
                <a class="header__link" href="{{ url('/login') }}">ログイン</a>
                <a class="header__link" href="{{ url('/mypage') }}">マイページ</a>
                <a class="header__btn" href="{{ url('/sell') }}">出品</a>
            @endguest

            @auth
                <form method="POST" action="/logout" class="header__logoutForm">
                    @csrf
                    <button type="submit" class="header__link header__btnLink">ログアウト</button>
                </form>
                <a class="header__link" href="{{ url('/mypage') }}">マイページ</a>
                <a class="header__btn" href="{{ url('/sell') }}">出品</a>
            @endauth
        </nav>
    </div>
</header>


<main class="main">
    @yield('content')
</main>

@yield('js')
</body>
</html>