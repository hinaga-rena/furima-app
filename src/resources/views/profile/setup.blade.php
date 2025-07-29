@extends('layouts.app')

@section('title', 'プロフィール設定')

@section('style')
<style>
    h1 {
        text-align: center;
        margin-top: 40px;
    }

    .container {
        max-width: 500px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .image-upload-section {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .image-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-preview {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
    }

    .default-icon {
        background: linear-gradient(#ccc); /* 好きな色に変更可能 */
        display: inline-block;
    }

    .upload-button {
        margin-right: 20px;
    }

    .upload-label {
        color: red;
        border: 1px solid red;
        padding: 6px 10px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.9rem;
        display: inline-block;
    }

    .predefined-images {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .predefined-image-option {
        display: inline-block;
        cursor: pointer;
        text-align: center;
    }

    .predefined-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid transparent;
    }

    .predefined-image-option input[type="radio"]:checked + .predefined-image {
        border-color: red;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="file"] {
        width: 100%;
        padding: 8px;
        font-size: 14px;
        box-sizing: border-box;
    }

    .submit-button {
        text-align: center;
    }

    .submit-button button {
        background-color: #ff6b6b;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
    }

    .submit-button button:hover {
        background-color: #ff4c4c;
    }

    /* タブレット（768px〜850px）対応 */
    @media screen and (min-width: 768px) and (max-width: 850px) {
        .container {
            padding: 30px 15px;
        }

        input[type="text"],
        input[type="file"] {
            font-size: 13px;
        }

        .submit-button button {
            width: 100%;
        }

        .image-upload-section {
            flex-direction: column;
            align-items: center;
        }

        .upload-button label {
            margin-top: 10px;
        }
    }

    /* PC（1400px〜1540px）対応 */
    @media screen and (min-width: 1400px) and (max-width: 1540px) {
        .container {
            max-width: 600px;
        }

        .submit-button button {
            font-size: 16px;
            padding: 14px 28px;
        }
    }
</style>
@endsection

@section('content')
<h1>プロフィール設定</h1>

<div class="container">
    <form method="POST" action="{{ route('profile.storeSetup') }}" enctype="multipart/form-data">
        @csrf

        <div class="image-upload-section">
            {{-- 現在のプロフィール画像を表示（未設定ならグレーアイコン） --}}
            <div class="image-wrapper">
                @if ($user->profile_image)
                    <img src="{{ asset($user->profile_image) }}" alt="プロフィール画像" class="profile-preview">
                @else
                    <img src="{{ asset('images/gray-icon.png') }}" alt="デフォルト画像" class="profile-preview default-icon">
                @endif
            </div>

            {{-- ファイルアップロード --}}
            <div class="upload-button">
                <label class="upload-label">
                    画像を選択する
                    <input type="file" name="profile_image" style="display: none;">
                </label>
            </div>

            {{-- 事前画像選択（ラジオボタンのみ） --}}
            <div class="predefined-images">
                @foreach ($predefinedImages as $image)
                    <label class="predefined-image-option">
                        <input type="radio" name="selected_image" value="{{ $image }}"
                            @if ($user->profile_image === $image) checked @endif>
                        <img src="{{ $image }}" alt="候補画像" class="predefined-image">
                    </label>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label>ユーザー名</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label>郵便番号</label>
            <input type="text" name="zip" value="{{ old('zip', $user->zip) }}">
        </div>

        <div class="form-group">
            <label>住所</label>
            <input type="text" name="address" value="{{ old('address', $user->address) }}">
        </div>

        <div class="form-group">
            <label>建物名</label>
            <input type="text" name="building" value="{{ old('building', $user->building) }}">
        </div>

        <div class="submit-button">
            <button type="submit">更新する</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.querySelector('input[name="profile_image"]');
        const previewImage = document.querySelector('.profile-preview');

        if (fileInput && previewImage) {
            fileInput.addEventListener('change', function (event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImage.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // ラジオボタンをクリックしたときもプレビュー更新
        const radioInputs = document.querySelectorAll('input[name="selected_image"]');
        radioInputs.forEach(function (radio) {
            radio.addEventListener('change', function () {
                if (radio.checked) {
                    previewImage.src = radio.value;
                }
            });
        });
    });
</script>
@endsection