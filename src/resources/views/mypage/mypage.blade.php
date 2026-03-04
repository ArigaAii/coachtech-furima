@extends('layouts.app')

@section('title', 'マイページ')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}?v={{ filemtime(public_path('css/mypage.css')) }}">
@endsection

@section('content')
<div class="mypage">

    {{-- 上段：プロフィール情報 --}}
    <div class="mypage__profile">
        <div class="mypage__avatar">
            @if(!empty($user->profile_image))
                <img
                    class="mypage__avatarImg"
                    src="{{ asset('storage/' . $user->profile_image) }}"
                    alt="プロフィール画像"
                >
            @else
                <div class="mypage__avatarPlaceholder">
                    {{ mb_substr($user->name, 0, 1) }}
                </div>
            @endif
        </div>

        <div class="mypage__name">{{ $user->name }}</div>

        <a class="mypage__editBtn" href="{{ route('mypage.profile.edit') }}">
            プロフィールを編集
        </a>
    </div>

    {{-- タブ --}}
    @php $tab = request('tab', 'listing'); // listing or purchase
    @endphp

    <div class="mypage__tabsLine">
        <div class="mypage__tabs">
            <a class="mypage__tab {{ $tab === 'listing' ? 'is-active' : '' }}"
                href="{{ route('mypage', ['tab' => 'listing']) }}">
                出品した商品
            </a>

            <a class="mypage__tab {{ $tab === 'purchase' ? 'is-active' : '' }}"
                href="{{ route('mypage', ['tab' => 'purchase']) }}">
                購入した商品
            </a>
        </div>
    </div>

    {{-- 一覧（グリッド） --}}
    <div class="mypage__grid">
        @if($tab === 'purchase')
            @if($purchases->count())
                @foreach($purchases as $purchase)
                    <a class="mypage__card" href="{{ route('items.show', $purchase->item->id) }}">
                        <div class="mypage__img">
                            <img src="{{ asset($purchase->item->image_path) }}" alt="{{ $purchase->item->name }}">
                        </div>
                        <div class="mypage__title">{{ $purchase->item->name }}</div>
                    </a>
                @endforeach
            @else
                <p class="mypage__empty">購入した商品はありません</p>
            @endif
        @else
            {{-- 出品一覧 --}}
            @if($listings->count())
                @foreach($listings as $item)
                    <a class="mypage__card" href="{{ route('items.show', $item->id) }}">
                        <div class="mypage__img">
                            <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}">
                        </div>
                        <div class="mypage__title">{{ $item->name }}</div>
                    </a>
                @endforeach
            @else
                <p class="mypage__empty">出品した商品はありません</p>
            @endif
        @endif
    </div>

</div>
@endsection

