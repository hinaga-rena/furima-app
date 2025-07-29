@extends('layouts.app')

@section('title', 'プロフィール編集')

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
    flex-direction: column;
    align-items: center;
    margin-bottom: 1.5rem;
}

.image-wrapper {
    margin-bottom: 1rem;
}

.profile-icon {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    display: block;
}

.profile-icon.placeholder {
    background-color: #ddd;
}

/* アップロードラベルをボタン風に */
.upload-label {
    background-color: #ff5c5c;
    color: white;
    padding: 8px 16px;
    border-radius: 5px;
    cursor: pointer;
    display: inline-block;
}

/* input自体は非表示 */
.upload-input {
    display: none;
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
            {{-- プレビュー表示 --}}
            <div class="image-wrapper">
                @if ($user->profile_image)
                    <img src="{{ asset($user->profile_image) }}" alt="プロフィール画像" class="profile-icon">
                @else
                    <div class="profile-icon placeholder"></div>
                @endif
            </div>

            {{-- アップロードボタン --}}
            <div class="upload-button">
                <label class="upload-label">
                    画像を選択する
                        <input type="file" name="profile_image" class="upload-input" style="display: none;">
                </label>
            </div>

            {{-- 事前画像のラジオ選択 --}}
            <div class="predefined-images" style="margin-top: 1rem;">
                    @foreach ($predefinedImages as $image)
                        <label style="display: inline-block; margin-right: 10px;">
                            <input type="radio" name="selected_image" value="{{ $image }}">
                            <img src="{{ $image }}" alt="候補画像" class="profile-icon" style="width: 80px; height: 80px; object-fit: cover;">
                        </label>
                    @endforeach
            </div>
        </div>

        <div class="form-group">
            <label>ユーザー名</label>
            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}">
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


@endsection