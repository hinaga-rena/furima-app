<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function index(Product $product)
    {
        if ($product->is_sold) {
            return redirect()->back()->with('error', 'この商品はすでに購入されています。');
        }

        $user = auth()->user();

        // 任意：直前に選択された支払い方法（セッションやDBに保存してるなら取り出す）
        $selectedPaymentMethod = session('payment_method', 'convenience'); // ← 例としてコンビニ支払いを初期値に

        return view('purchase.index', compact('product', 'user', 'selectedPaymentMethod'));
    }

    public function complete(Request $request, Product $product)
    {
        // ここで購入処理（例：購入テーブルに記録など）
        if ($product->is_sold) {
            return back()->with('error', 'すでに購入されています。');
        }

        // 商品に「SOLD」フラグをつける処理例
        $product->is_sold = true;
        $product->save();

        // 購入履歴の保存
        Purchase::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'payment_method' => $request->input('payment_method', 'card'), // デフォルト値
            'address' => Auth::user()->address, // プロフィールから取得
        ]);

        // ⭐️ セッションに選択した支払い方法を保存
        session(['payment_method' => $request->payment_method]);

        // リダイレクトなど
        return redirect()->route('products.index')->with('status', '購入が完了しました！');
    }
}
