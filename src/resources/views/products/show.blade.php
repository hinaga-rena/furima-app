@extends('layouts.app')

@section('title', $product->name . ' | 商品詳細')

@section('style')
<style>
    body {
        font-family: sans-serif;
        margin: 0;
        background-color: #fff;
    }
    .container {
        display: flex;
        flex-wrap: wrap;
        max-width: 1200px;
        margin: 2rem auto;
        padding: 1rem;
    }
    .product-image {
        flex: 1 1 40%;
        max-width: 500px;
        margin-right: 2rem;
    }
    .product-image img {
        width: 100%;
        object-fit: cover;
    }
    .product-detail {
        flex: 1 1 50%;
    }
    .price {
        font-size: 1.8rem;
        margin: 1rem 0;
    }
    .icons {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-top: 10px;
    }
    .icon-btn {
        background: none;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 0;
    }
    .icon-count {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .icon {
        width: 20px;
        height: 20px;
    }
    .purchase-btn {
        background-color: #ff5c5c;
        color: white;
        padding: 0.8rem 2rem;
        border: none;
        font-weight: bold;
        font-size: 1rem;
        border-radius: 4px;
        cursor: pointer;
        margin-bottom: 2rem;
    }
    .section-title {
        font-weight: bold;
        font-size: 1.2rem;
        margin-top: 2rem;
        margin-bottom: 0.5rem;
    }
    .description, .info {
        margin-bottom: 1.5rem;
    }
    .tag {
        display: inline-block;
        background: #f8f8f8;
        border: 1px solid #ccc;
        padding: 0.3rem 0.8rem;
        border-radius: 999px;
        margin: 0 0.5rem 0.5rem 0;
        font-size: 0.9rem;
    }
    .comment-box {
        margin-top: 2rem;
    }
    .comment {
        margin-bottom: 1rem;
        border-bottom: 1px solid #eee;
        padding-bottom: 1rem;
    }
    .comment-user {
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .comment-user img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
    }
    .comment-text {
        margin-top: 0.5rem;
        background-color: #f5f5f5;
        padding: 0.5rem;
        border-radius: 4px;
    }
    textarea {
        width: 100%;
        height: 100px;
        padding: 0.6rem;
        margin-top: 1rem;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .comment-submit {
        margin-top: 1rem;
        background-color: #ff5c5c;
        color: #fff;
        border: none;
        padding: 0.7rem 1.5rem;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
    }
    @media (max-width: 768px) {
        .container {
            flex-direction: column;
            padding: 1rem;
        }
        .product-image {
            margin-right: 0;
            margin-bottom: 2rem;
        }

    @media screen and (min-width: 1400px) and (max-width: 1540px) {
            /* PC対応 */
        }

    @media screen and (min-width: 768px) and (max-width: 850px) {
            /* タブレット対応 */
        }
    }


</style>
@endsection

@section('content')
<div class="container">
    <div class="product-image">
        <img src="{{ $product->image_url }}" alt="商品画像">
    </div>
    <div class="product-detail">
        <h2>{{ $product->name }}</h2>
        <p>{{ $product->brand }}</p>
        <div class="price">¥{{ number_format($product->price) }}（税込）</div>

        <div class="icons">
            <form method="POST" action="{{ route('products.like', $product->id) }}">
                @csrf
                <button type="submit" class="icon-btn">
                    @if(Auth::check() && $product->likes->contains('user_id', Auth::id()))
                        <img src="/images/icon_star.png" alt="いいね済み" class="icon">
                    @else
                        <img src="/images/icon_star_gray.png" alt="未いいね" class="icon">
                    @endif
                    <span>{{ $product->likes_count }}</span>
                </button>
            </form>

            <div class="icon-count">
                <img src="/images/icon_comment.png" alt="コメント" class="icon">
                <span>{{ $product->comments->count() }}</span>
            </div>
        </div>

        <form method="GET" action="{{ route('purchase.index', ['product' => $product->id]) }}">
            <button type="submit" class="purchase-btn">購入手続きへ</button>
        </form>

        <div class="description">
            <div class="section-title">商品説明</div>
            <p>{{ $product->description }}</p>
        </div>

        <div class="info">
            <div class="section-title">商品の情報</div>
            <p>カテゴリー：
                @foreach ($product->categories as $category)
                    <span class="tag">{{ $category->name }}</span>
                @endforeach
            </p>
            <p>商品の状態：{{ $product->condition }}</p>
        </div>

        <div class="comment-box">
            <div class="section-title">コメント（{{ $product->comments->count() }}）</div>

            @foreach ($product->comments as $comment)
                <div class="comment">
                    <div class="comment-user">
                        <img src="/images/default-user.png" alt="ユーザー">
                        {{ $comment->user->name }}
                    </div>
                    <div class="comment-text">{{ $comment->content }}</div>
                </div>
            @endforeach

            @auth
                <form method="POST" action="{{ route('products.comment', $product->id) }}">
                    @csrf
                    <textarea name="content" required maxlength="255" placeholder="商品へのコメント"></textarea>
                    @error('content')
                        <div style="color:red;">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="comment-submit">コメントを送信する</button>
                </form>
            @endauth
        </div>
    </div>
</div>

@endsection