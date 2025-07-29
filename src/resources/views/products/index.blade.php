@extends('layouts.app')

@section('title', '商品一覧')

@section('style')
<style>
    .tabs {
        display: flex;
        padding: 16px 24px;
        border-bottom: 1px solid #ccc;
        font-weight: bold;
    }

    .tab {
        margin-right: 24px;
        font-size: 16px;
        color: #555;
        text-decoration: none;
    }

    .tab.active {
        color: red;
    }

    .product-list {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        padding: 30px 20px;
        justify-content: space-between;
    }

    .product-item {
        width: calc((100% - 4 * 20px) / 5); /* 5列 */
        text-align: center;
    }

    .sold-label {
        position: absolute;
        top: 8px;
        left: 8px;
        background: red;
        color: white;
        padding: 4px 8px;
        font-weight: bold;
        border-radius: 4px;
    }

    /* タブレット（768〜850px）→ 2列 */
    @media screen and (min-width: 768px) and (max-width: 850px) {
        .product-item {
            width: calc((100% - 1 * 20px) / 2);
        }
    }

    /* PC（1400〜1540px）→ 4列 */
    @media screen and (min-width: 1400px) and (max-width: 1540px) {
        .product-item {
            width: calc((100% - 3 * 20px) / 4);
        }
    }

    /* スマホ（〜767px）→ 1列 */
    @media screen and (max-width: 767px) {
        .product-item {
            width: 100%;
        }
    }

    .product-link {
        display: block;
        text-decoration: none;
        color: inherit;
    }

    .product-image {
        width: 100%;
        aspect-ratio: 1 / 1;
        background-color: #ddd;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    .product-name {
        margin-top: 6px;
        font-size: 14px;
    }
</style>
@endsection

@section('content')
<div class="tabs">
    <a href="{{ route('products.index') }}"
        class="tab {{ request('like') ? '' : 'active' }}">
        おすすめ
    </a>
    <a href="{{ route('products.index', ['like' => 1]) }}"
        class="tab {{ request('like') ? 'active' : '' }}">
        マイリスト
    </a>
</div>

<div class="product-list">
@foreach ($products->take(10) as $product)
    <div class="product-item">
        <a href="{{ route('products.show', ['product' => $product->id]) }}" class="product-link">
            <div class="product-image" style="position: relative;">

                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                @if ($product->is_sold)
                <div class="sold-label">SOLD</div>
                @endif
            </div>
            <div class="product-name">{{ $product->name }}</div>
        </a>
    </div>
@endforeach
</div>
@endsection