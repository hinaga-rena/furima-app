@extends('layouts.app')

@section('title', '商品購入')

@section('style')
<style>
.purchase-container {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    max-width: 1000px;
    margin: 40px auto;
    gap: 20px;
}

.left-box, .right-box {
    background: #fff;
    padding: 20px;
}

.left-box {
    flex: 1;
    width: 60%;
}

/* 右側：金額＋購入ボタン */
.right-side {
    width: 320px;
    display: flex;
    flex-direction: column;
    align-items: stretch;
}

/* 合計・支払い情報 */
.right-box {
    border: 1px solid #ccc;
    padding: 20px;
    margin-bottom: 20px;
}

/* 購入ボタン */
.purchase-btn {
    background-color: #ff5c5c;
    color: white;
    border: none;
    padding: 12px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 4px;
}


.product-info {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
}

.product-image {
    width: 150px;
    height: 150px;
    background: #ddd;
}

.product-name {
    font-size: 20px;
    font-weight: bold;
}

.product-price {
    font-size: 18px;
    margin-top: 10px;
}

.section-title {
    font-weight: bold;
    margin: 30px 0 10px;
    border-bottom: 1px solid #ccc;
    padding-bottom: 5px;
}

select {
    padding: 10px;
    width: 250px;
}

.address {
    margin-top: 10px;
    line-height: 1.6;
}

.section-title.d-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.change-address {
    font-size: 14px;
    color: #007bff;
    text-decoration: underline;
    display: inline; /* 念のため明示 */
}

.purchase-summary {
    border-top: 1px solid #ccc;
    margin-top: 20px;
    padding-top: 20px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

button.purchase-btn {
    background-color: #ff5c5c;
    color: white;
    border: none;
    padding: 14px 0;
    width: 100%;
    font-size: 16px;
    border-radius: 4px;
    margin-top: 20px;
    cursor: pointer;
}

/* ✅ タブレット対応（768〜850px） */
@media screen and (max-width: 850px) and (min-width: 768px) {
    .purchase-container {
        flex-direction: column;
        align-items: center;
    }

    .right-side {
        width: 100%;
    }
    .purchase-btn {
        width: 100%;
    }
}

/* ✅ PC幅（1400px〜1540px） */
@media screen and (min-width: 1400px) and (max-width: 1540px) {
    .purchase-container {
        padding: 30px;
    }
    .purchase-btn {
        font-size: 18px;
    }
}
</style>
@endsection

@section('content')

<form method="POST" action="{{ route('purchase.complete', $product->id) }}">
    @csrf
    <div class="purchase-container">
        <div class="left-box">
            <div class="product-info">
                <div class="product-image">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div>
                    <div class="product-name">{{ $product->name }}</div>
                    <div class="product-price">¥{{ number_format($product->price) }}</div>
                </div>
            </div>

            <div class="section-title">支払い方法</div>
            <select id="payment_method" name="payment_method" required onchange="updatePaymentLabel()">
                <option value="">選択してください</option>
                <option value="convenience" {{ $selectedPaymentMethod === 'convenience' ? 'selected' : '' }}>コンビニ払い</option>
                <option value="card" {{ $selectedPaymentMethod === 'card' ? 'selected' : '' }}>カード払い</option>
            </select>

                <div class="section-title d-flex">
                <span>配送先</span>
                <a href="{{ route('address.edit', ['product_id' => $product->id]) }}" class="change-address">変更する</a>
            </div>
            <div class="address">
                〒{{ $user->zip }}<br>
                {{ $user->address }} {{ $user->building }}
            </div>
        </div>

        <div class="right-side">
            <div class="right-box">
                <div class="summary-row">
                    <div>商品代金</div>
                    <div>¥{{ number_format($product->price) }}</div>
                </div>
                <div class="summary-row">
                    <div>支払い方法</div>
                    <div id="payment_summary_text">{{ $selectedPaymentMethod === 'card' ? 'カード払い' : 'コンビニ払い' }}</div>
                </div>
            </div>
            <button type="submit" class="purchase-btn">購入する</button>
        </div>
    </div>
</form>
<script>
function updatePaymentLabel() {
    const selected = document.getElementById('payment_method').value;
    const summaryText = selected === 'card' ? 'カード払い' : 'コンビニ払い';
    document.getElementById('payment_summary_text').textContent = summaryText;
}
</script>
@endsection