@extends('layouts.app')

@section('title','購入手続き')

@section('content')
<div class="purchase">
    <div class="purchase__container">

        <form method="POST" action="{{ route('purchase.checkout', $item->id) }}" class="purchase__grid">
            @csrf

            <div class="purchase__left">
                <div class="purchase__item">
                    <div class="purchase__thumb">
                        @if(!empty($item->image_path))
                            <img class="purchase__thumb-img" src="{{ asset($item->image_path) }}" alt="{{ $item->name }}">
                        @else
                            <div class="purchase__thumb-ph">商品画像</div>
                        @endif
                    </div>

                    <div class="purchase__item-meta">
                        <div class="purchase__item-name">{{ $item->name }}</div>
                        <div class="purchase__item-price">¥{{ number_format($item->price) }}</div>
                    </div>
                </div>

                <hr class="purchase__hr">

                <div class="purchase__section">
                    <div class="purchase__section-title">支払い方法</div>

                    <select name="payment_method" class="purchase__select" required {{ $item->is_sold ? 'disabled' : '' }}>
                        <option value="">選択してください</option>
                        <option value="convenience">コンビニ払い</option>
                        <option value="card">クレジットカード</option>
                    </select>

                    @error('payment_method')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="purchase__hr">

                <div class="purchase__section">
                    <div class="purchase__section-head">
                        <div class="purchase__section-title">配送先</div>
                        <a class="purchase__change" href="{{ route('purchase.address.edit', $item->id) }}">変更する</a>
                    </div>

                    @php
                        $addr = session("purchase_address.$item->id", [
                            'postcode' => $user->postcode,
                            'address' => $user->address,
                            'building_name' => $user->building_name,
                        ]);
                    @endphp

                    <div class="purchase__address">
                        <div>〒 {{ $address['postcode'] ?? 'XXX-YYYY' }}</div>
                        <div>{{ $address['address'] ?? 'ここには住所が入ります' }}</div>
                        <div>{{ $address['building_name'] ?? '' }}</div>
                    </div>
                </div>
            </div>

            <div class="purchase__right">
                <div class="purchase__summary">
                    <div class="purchase__row">
                        <div class="purchase__label">商品代金</div>
                        <div class="purchase__value">¥{{ number_format($item->price) }}</div>
                    </div>

                    <div class="purchase__row purchase__row--last">
                        <div class="purchase__label">支払い方法</div>
                        <div class="purchase__value" id="js-payment-label">選択してください</div>
                    </div>
                </div>
                <div class="purchase__btnWrap">
                    @if(!$item->is_sold)
                        <button type="submit" class="purchase__btn">購入する</button>
                    @else
                        <p class="purchase__sold-text">売り切れました</p>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const select = document.querySelector('select[name="payment_method"]');
    const label = document.getElementById('js-payment-label');

    const map = {
        '': '選択してください',
        'convenience': 'コンビニ払い',
        'card': 'クレジットカード'
    };

    if (select && label) {
    const update = () => label.textContent = map[select.value] ?? '選択してください';
    select.addEventListener('change', update);
    update();
    }
</script>

@endsection

