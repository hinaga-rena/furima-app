@extends('layouts.app')

@section('title', '住所の変更')

@section('style')
<style>
    .form-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 20px;
        text-align: left;
    }

    .form-container h2 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 24px;
        font-weight: bold;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 6px;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        box-sizing: border-box;
    }

    .submit-btn {
        display: block;
        width: 100%;
        padding: 12px;
        background-color: #ff5a5a;
        color: white;
        font-size: 16px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        margin-top: 20px;
    }

    @media (min-width: 768px) and (max-width: 850px) {
        .form-container {
            max-width: 90%;
            padding: 15px;
        }

        .form-container h2 {
            font-size: 22px;
        }

        .form-group input {
            font-size: 15px;
        }
    }

    @media (min-width: 1400px) and (max-width: 1540px) {
        .form-container {
            max-width: 700px;
        }

        .form-container h2 {
            font-size: 26px;
        }

        .form-group input {
            font-size: 17px;
        }

        .submit-btn {
            font-size: 17px;
        }
    }
</style>
@endsection

@section('content')
<div class="form-container">
    <h2>住所の変更</h2>
    <form method="POST" action="{{ route('address.update') }}">
        @csrf
        @method('PUT')

        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <div class="form-group">
            <label for="zip">郵便番号</label>
            <input type="text" id="zip" name="zip" value="{{ old('zip', $user->zip) }}">
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}">
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" id="building" name="building" value="{{ old('building', $user->building) }}">
        </div>

        <button type="submit" class="submit-btn">更新する</button>
    </form>
</div>
@endsection