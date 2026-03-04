@extends('layouts.app')

@section('title','出品手続き')

@section('content')
<div class="sell">
    <h1 class="sell__title">商品の出品</h1>

    <form class="sell__form" method="POST" action="{{ route('sell.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- 商品画像 --}}
        <div class="sell__section">
            <p class="sell__label">商品画像</p>

            <div class="sell__image-box">
                <label class="sell__image-btn" for="image">画像を選択する</label>
                <input id="image" type="file" name="image" name="image" accept="image/*">
            </div>

            @error('image') <p class="sell__error">{{ $message }}</p> @enderror
        </div>

        {{-- 商品の詳細 --}}
        <div class="sell__section">
            <h2 class="sell__heading">商品の詳細</h2>

            {{-- カテゴリー --}}
            <p class="sell__label">カテゴリー</p>
            <div class="sell__categories">
                @foreach($categories as $cat)
                    <label class="sell__category">
                        <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}"
                            {{ in_array($cat->id, old('category_ids', [])) ? 'checked' : '' }}>
                        <span class="sell__categoryTag">{{ $cat->name }}</span>
                    </label>
                @endforeach
            </div>
            @error('category_ids') <p class="sell__error">{{ $message }}</p> @enderror
            @error('category_ids.*') <p class="sell__error">{{ $message }}</p> @enderror

            {{-- 状態 --}}
            <p class="sell__label">商品の状態</p>
            <select name="status">
                <option value="">選択してください</option>
                <option value="new" {{ old('status')==='new' ? 'selected' : '' }}>良好</option>
                <option value="good" {{ old('status')==='good' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                <option value="used" {{ old('status')==='used' ? 'selected' : '' }}>やや傷や汚れあり</option>
                <option value="bad" {{ old('status')==='bad' ? 'selected' : '' }}>状態が悪い</option>
            </select>
            @error('status') <p class="sell__error">{{ $message }}</p> @enderror
        </div>

        {{-- 商品名と説明 --}}
        <div class="sell__section">
            <h2 class="sell__heading">商品名と説明</h2>

            <p class="sell__label">商品名</p>
            <input type="text" name="name" value="{{ old('name') }}">
            @error('name') <p class="sell__error">{{ $message }}</p> @enderror

            <p class="sell__label">ブランド名</p>
            <input type="text" name="brand_name" value="{{ old('brand_name') }}">
            @error('brand_name') <p class="sell__error">{{ $message }}</p> @enderror

            <p class="sell__label">商品の説明</p>
            <textarea name="description" rows="6">{{ old('description') }}</textarea>
            @error('description') <p class="sell__error">{{ $message }}</p> @enderror
        </div>

        {{-- 販売価格 --}}
        <div class="sell__section">
            <p class="sell__label">販売価格</p>

            <div class="sell__price-group">
                <span class="sell__price-prefix">¥</span>
                <input class="sell__price-field" type="number" name="price" value="{{ old('price') }}" min="0">
            </div>

            @error('price')
                <p class="sell__error">{{ $message }}</p>
            @enderror
        </div>

        <button class="sell__submit" type="submit">出品する</button>
    </form>
</div>
@endsection
