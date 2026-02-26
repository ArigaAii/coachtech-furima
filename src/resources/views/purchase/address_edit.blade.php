@extends('layouts.app')

@section('title','住所の変更')

@section('content')
<div class="address-edit">
    <div class="address-edit__card">
        <h1 class="address-edit__title">住所の変更</h1>

        <form method="POST" action="{{ route('purchase.address.update', $item->id) }}">
            @csrf

            <div class="address-edit__field">
                <label class="address-edit__label">郵便番号</label>
                <input type="text" name="postcode" value="{{ old('postcode', $address['postcode'] ?? '') }}">
                @error('postcode') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="address-edit__field">
                <label class="address-edit__label">住所</label>
                <input type="text" name="address" value="{{ old('address', $address['address'] ?? '') }}">
                @error('address') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="address-edit__field">
                <label class="address-edit__label">建物名</label>
                <input type="text" name="building_name" value="{{ old('building_name', $address['building_name'] ?? '') }}">
                @error('building_name') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="address-edit__actions">
                <button class="address-edit__submit" type="submit">更新する</button>
            </div>
        </form>
    </div>
</div>
@endsection
