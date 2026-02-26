@extends('layouts.app')

@section('title', 'プロフィール設定')

@section('content')
<div class="page">
    <div class="auth">
        <h1 class="auth__title">プロフィール設定</h1>

        <form class="auth__form" action="{{ route('mypage.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group profile-image-group">
                <label class="form-label"></label>

                <div class="profile-image-row">
                    <div class="profile-image-wrapper">
                        @if(!empty(auth()->user()->profile_image))
                            <img
                                id="preview"
                                class="profile-image"
                                src="{{ asset('storage/' . auth()->user()->profile_image) }}"
                                alt="プロフィール画像">
                        @else
                            <div id="preview" class="profile-image profile-image--empty"></div>
                        @endif
                    </div>
                
                    <label class="image-select-btn" for="profile_image_input">
                        画像を選択する
                    </label>
                
                    <input
                        id="profile_image_input"
                        type="file"
                        name="profile_image"
                        accept=".jpg,.jpeg,.png"
                        class="visually-hidden">
                </div>

                @error('profile_image')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">ユーザー名</label>
                <input class="form-input" type="text" name="name" value="{{ old('name', auth()->user()->name) }}">
                @error('name') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">郵便番号</label>
                <input class="form-input" type="text" name="postcode" value="{{ old('postcode', auth()->user()->postcode) }}">
                @error('postcode') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">住所</label>
                <input class="form-input" type="text" name="address" value="{{ old('address', auth()->user()->address ?? '') }}">
                @error('address') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">建物名</label>
                <input class="form-input" type="text" name="building_name" value="{{ old('building_name', auth()->user()->building_name ?? '') }}">
                @error('building_name') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <button class="btn btn--primary" type="submit">更新する</button>
        </form>
    </div>
</div>

@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('profile_image_input');
    if (!input) return;

    input.addEventListener('change', (e) => {
        const file = e.target.files?.[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = () => {
            const preview = document.getElementById('preview');
            if (!preview) return;

            // preview が div の場合は img に置き換える
            if (preview.tagName !== 'IMG') {
                const img = document.createElement('img');
                img.id = 'preview';
                img.className = 'profile-image';
                img.alt = 'プロフィール画像';
                img.src = reader.result;

                preview.replaceWith(img);
                return;
            }

            preview.src = reader.result;
        };

        reader.readAsDataURL(file);
    });
});
</script>
@endsection