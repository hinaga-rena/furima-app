<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;


class AddressController extends Controller
{
    // 住所変更画面を表示
    public function edit(Request $request)
    {
        $user = Auth::user();

        // 商品IDをクエリパラメータなどから取得
        $productId = $request->input('product_id');

        // 商品情報を取得（なければ404）
        $product = Product::findOrFail($productId);

        return view('purchase.address', [
        'user' => $user,
        'product' => $product,
        ]);
    }

    // 住所を更新
    public function update(Request $request)
    {
        $request->validate([
            'postal_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->update([
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        // 商品購入確認画面にリダイレクト（確認画面が `purchase.confirm` の場合）
        return redirect()->route('purchase.index', ['product' => $request->product_id])
        ->with('success', '住所を更新しました');
    }
}