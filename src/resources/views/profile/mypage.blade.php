@extends('layouts.app')

@section('title', 'マイページ')

@section('style')
<style>
    .profile-header {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 100px;
        margin-top: 30px;
    }

    .container {
        padding: 20px;
        text-align: center;
    }

    .profile-icon {
        width: 100px;
        height: 100px;
        background-color: #ccc;
        border-radius: 50%;
        overflow: hidden; /* ← 重要！ */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-icon img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* ← はみ出さず枠に収まる */
    }

    .username {
        font-size: 24px;
        font-weight: bold;
        margin: 10px 0;
    }

    .edit-btn {
        border: 1px solid red;
        color: red;
        background: none;
        font-size: 14px;
        border-radius: 5px;
        cursor: pointer;
        padding: 10px 20px;
    }

    .tabs {
        display: flex;
        justify-content: center;
        margin-top: 30px;
        border-bottom: 1px solid #999;
    }

    .tab {
        margin: 0 16px;
        padding: 10px;
        font-weight: bold;
        color: #555;
        cursor: pointer;
    }

    .tab.active {
        color: red;
    }

    .product-list {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
        padding: 20px;
    }

    .product-item {
        text-align: center;
    }

    .product-image {
        width: 100%;
        padding-top: 100%;
        background-color: #ddd;
        position: relative;
    }

    .product-image img {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        top: 0;
        left: 0;
    }

    .product-name {
        margin-top: 8px;
    }

    /* タブレット対応（768px〜850px） */
@media screen and (min-width: 768px) and (max-width: 850px) {
    .profile-header {
        flex-direction: column;
        gap: 20px;
    }

    .product-list {
        grid-template-columns: repeat(2, 1fr); /* 2列表示 */
    }

    .edit-btn {
        width: 100%;
        padding: 12px;
    }
}

/* PC対応（1400px〜1540px） */
@media screen and (min-width: 1400px) and (max-width: 1540px) {
    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .product-list {
        grid-template-columns: repeat(4, 1fr); /* 4列表示 */
    }

    .edit-btn {
        font-size: 16px;
        padding: 12px 24px;
    }
}
</style>
@endsection

@section('content')
<div class="container">
    <div class="container">
        <div class="profile-header">
            <div class="profile-icon">
                <img src="{{ Auth::user()->profile_image ?? asset('images/default_user.png') }}" alt="プロフィール画像">
            </div>
            <div class="username">{{ Auth::user()->name }}</div>
            <button class="edit-btn" onclick="location.href='{{ route('profile.setup') }}'">プロフィールを編集</button>
        </div>
    </div>

    <div class="tabs">
        <a href="{{ route('mypage', ['page' => 'sell']) }}" class="tab {{ $page === 'sell' ? 'active' : '' }}">出品した商品</a>
        <a href="{{ route('mypage', ['page' => 'buy']) }}" class="tab {{ $page === 'buy' ? 'active' : '' }}">購入した商品</a>
    </div>

    <div class="product-list">
    @if ($page === 'sell')
        @foreach($products as $product)
            <div class="product-item">
                <div class="product-image">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                </div>
                <div class="product-name">{{ $product->name }}</div>
            </div>
        @endforeach
    @elseif ($page === 'buy')
        @foreach($purchases as $purchase)
            <div class="product-item">
                <div class="product-image">
                    <img src="{{ asset('storage/' . $purchase->product->image) }}" alt="{{ $purchase->product->name }}">
                </div>
                <div class="product-name">{{ $purchase->product->name }}</div>
            </div>
        @endforeach
    @endif
    </div>
</div>
@endsection