@extends('layouts.app')

@section('title', '商品の出品')

@section('style')
<style>
    .container {
        max-width: 700px;
        margin: 40px auto;
        padding: 0 20px;
    }

    h1 {
        font-size: 24px;
        margin-bottom: 24px;
        text-align: center;
    }

    label {
        display: block;
        margin: 16px 0 8px;
        font-weight: bold;
    }

    input[type="text"],
    textarea,
    select {
        width: 100%;
        padding: 8px;
        margin-bottom: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .image-upload {
    border: 1px dashed #ccc;
    padding: 40px;
    text-align: center;
    margin-bottom: 24px;
    position: relative;
    }

    .custom-file-label {
        display: inline-block;
        padding: 10px 20px;
        border: 2px solid #ff6b6b;
        color: #ff6b6b;
        border-radius: 10px;
        font-size: 16px;
        cursor: pointer;
        font-weight: bold;
        background-color: #fff;
        transition: background-color 0.3s, color 0.3s;
    }

    .custom-file-label:hover {
        background-color: #ff6b6b;
        color: white;
    }

    .category-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 16px;
    }

    .category-label {
        cursor: pointer;
        display: inline-flex;
        align-items: center;
    }

    .category-label input[type="checkbox"] {
        display: none;
    }

    .category-label span {
        border: 1px solid #ff6b6b;
        color: #ff6b6b;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 14px;
        background-color: transparent;
        transition: background-color 0.2s, color 0.2s;
    }

    .category-label input[type="checkbox"]:checked + span {
        background-color: #ff6b6b;
        color: #fff;
    }
    .submit-button {
        background: #f66;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        width: 100%;
        cursor: pointer;
    }

    /* ▼▼ レスポンシブ対応 ▼▼ */

    /* タブレット（768〜850px） */
    @media screen and (min-width: 768px) and (max-width: 850px) {
        .container {
            max-width: 90%;
            padding: 0 10px;
        }

        h1 {
            font-size: 20px;
        }

        .category-buttons {
        justify-content: center;
    }
    }

    /* PC（1400〜1540px） */
    @media screen and (min-width: 1400px) and (max-width: 1540px) {
        .container {
            max-width: 900px;
        }
    }

</style>
@section('content')
<div class="container">
    <h1>商品の出品</h1>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>商品画像</label>
        <div class="image-upload">
            {{-- ファイルアップロード --}}
            <label for="image-input" class="custom-file-label">画像を選択する</label>
            <input type="file" id="image-input" name="image" style="display: none;" accept="image/*">

            {{-- プレビュー表示用 --}}
            <div id="preview" style="margin-top: 16px;">
                <img id="preview-image" src="#" alt="プレビュー画像" style="max-width: 100%; display: none;">
            </div>
        </div>

        {{-- プレビュー用スクリプト --}}
        <script>
            document.getElementById('image-input').addEventListener('change', function (event) {
                const file = event.target.files[0];
                const previewImage = document.getElementById('preview-image');

                if (file) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            previewImage.src = e.target.result;
                            previewImage.style.display = 'block';
                        };

                        reader.readAsDataURL(file);
                } else {
                    previewImage.style.display = 'none';
                }
            });
        </script>

        <h3>商品の詳細</h3>

        <label>カテゴリー</label>
            <div class="category-buttons">
                @foreach ($categories as $category)
                    <label class="category-label">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                        <span>{{ $category->name }}</span>
                    </label>
                @endforeach
            </div>

        <label>商品の状態</label>
        <select name="condition" required>
            <option value="">選択してください</option>
            <option value="新品">新品</option>
            <option value="未使用に近い">未使用に近い</option>
            <option value="良好">良好</option>
            <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
            <option value="やや傷や汚れあり">やや傷や汚れあり</option>
            <option value="状態が悪い">状態が悪い</option>
        </select>

        <h3>商品名と説明</h3>

        <label>商品名</label>
        <input type="text" name="name" required>

        <label>ブランド名</label>
        <input type="text" name="brand">

        <label>商品の説明</label>
        <textarea name="description" rows="5" required></textarea>

        <label>販売価格</label>
        <input type="text" name="price" placeholder="¥" required>

        <button class="submit-button" type="submit">出品する</button>
    </form>
</div>
@endsection