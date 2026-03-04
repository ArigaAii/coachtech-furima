@extends('layouts.app')

@section('title', '商品詳細')

@section('content')
<div class="item-show">
    <div class="item-show__grid">
        {{-- 左：商品画像 --}}
        <div class="item-show__image">
            @if(!empty($item->image_path))
                <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}">
            @endif

            @if($item->is_sold)
                <span class="item-show__sold">Sold</span>
            @endif
        </div>

        {{-- 右：商品情報 --}}
        <div class="item-show__info">
            <h1 class="item-show__name">{{ $item->name }}</h1>

            @if($item->brand_name)
                <div class="item-show__brand">{{ $item->brand_name }}</div>
            @endif

            <div class="item-show__price">
                ¥{{ number_format($item->price) }}
                <span class="item-show__tax">(税込)</span>
            </div>

            <div class="item-show__meta">
                <div class="item-show__meta-item">
                    @auth
                        @php
                            $liked = auth()->check() && $item->isLikedBy(auth()->user());
                            $heartSrc = $liked ? 'images/heartpink.png' : 'images/heartlogo.png';
                        @endphp

                        <form method="POST" action="{{ route('items.like', ['item' => $item->id]) }}">
                            @csrf
                            <button type="submit" class="item-show__icon-btn" aria-label="いいね">
                                <img src="{{ asset($heartSrc) }}" alt="いいね" class="item-show__icon-img">
                            </button>
                        </form>
                    @else
                        <a href="{{ url('/login') }}" class="item-show__icon-btn" aria-label="ログインしていいね">
                            <img src="{{ asset('images/heartlogo.png') }}" alt="いいね" class="item-show__icon-img">
                        </a>
                    @endauth

                    <div class="item-show__count">{{ $item->likes_count ?? 0 }}</div>
                </div>

                <div class="item-show__meta-item">
                    <div class="item-show__icon-btn" aria-label="コメント">
                        <img src="{{ asset('images/commentlogo.png') }}" alt="コメント" class="item-show__icon-img">
                    </div>
                    <div class="item-show__count">{{ $item->comments->count() }}</div>
                </div>
            </div>

            <a class="item-show__buy" href="{{ url('/purchase/'.$item->id) }}">購入手続きへ</a>

            <h2 class="item-show__section-title">商品説明</h2>
            <p class="item-show__desc">{{ $item->description }}</p>

            <h2 class="item-show__section-title">商品の情報</h2>
            <dl class="item-show__dl">
                <dt>カテゴリー</dt>
                <dd>
                    @foreach($item->categories as $category)
                        <span class="item-show__tag">
                            {{ $category->name }}
                        </span>
                    @endforeach
                </dd>
                <dt>商品の状態</dt>
                @if($item->status)
                    <div class="item-show__status">{{ $item->status_label }}</div>
                @endif
            </dl>

            <h2 class="item-show__section-title_s">
                コメント({{ $item->comments->count() }})
            </h2>

            @foreach($item->comments as $comment)
                <div class="item-show__comment">

                    <div class="item-show__comment-head">
                        <div class="item-show__avatar">
                            @if(!empty($comment->user->profile_image))
                                <img
                                    src="{{ asset('storage/' . $comment->user->profile_image) }}"
                                    alt="avatar"
                                    class="item-show__avatar-img"
                                >
                            @endif
                        </div>
                        <div class="item-show__comment-name">{{ $comment->user->name }}</div>
                    </div>

                    <div class="item-show__comment-text">{{ $comment->body }}</div>

                </div>
            @endforeach

            <h2 class="item-show__section-title">商品へのコメント</h2>

            @auth
                <form method="POST" action="{{ route('items.comments.store', ['item' => $item->id]) }}" class="item-show__form">
                    @csrf

                    @error('body')
                        <p class="form-error">{{ $message }}</p>
                    @enderror

                    <textarea name="body" rows="4" class="item-show__textarea">{{ old('body') }}</textarea>
                    <button type="submit" class="item-show__submit">コメントを送信する</button>
                </form>
            @else
                <div class="item-show__form">
                    <textarea rows="4" class="item-show__textarea" disabled></textarea>

                    <a href="{{ url('/login') }}" class="item-show__submit item-show__submit--link">
                        コメントを送信する
                    </a>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection
