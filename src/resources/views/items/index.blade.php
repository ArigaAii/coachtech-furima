@extends('layouts.app')

@section('title', '商品一覧')

@section('content')

@php
    $query = request()->query();
@endphp

<div class="tabs-wrapper">
    <div class="tabs">
        <a class="tabs__link {{ $tab === 'recommend' ? 'is-active' : '' }}"
            href="{{ url('/?' . http_build_query(array_merge($query, ['tab' => null]))) }}">
            おすすめ
        </a>

        <a class="tabs__link {{ $tab === 'mylist' ? 'is-active' : '' }}"
            href="{{ url('/?' . http_build_query(array_merge($query, ['tab' => 'mylist']))) }}">
            マイリスト
        </a>
    </div>
</div>

<div class="items">
@foreach($items as $item)
    <a class="item-card" href="{{ route('items.show', ['item_id' => $item->id]) }}">

        <div class="item-card__img">
            @if(!empty($item->image_path))
                <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}">
            @endif

            {{-- Sold表示 --}}
            @if($item->is_sold)
                <span class="item-card__sold">Sold</span>
            @endif
        </div>

        <div class="item-card__body">
            <p class="item-card__name">{{ $item->name }}</p>
        </div>
    </a>
@endforeach
</div>

@endsection
