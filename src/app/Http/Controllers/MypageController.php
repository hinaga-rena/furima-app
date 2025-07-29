<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Purchase;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->query('page', 'sell'); // デフォルトは「出品」

        if ($page === 'buy') {
            // 購入した商品一覧
            $purchases = Purchase::with('product')
                ->where('user_id', Auth::id())
                ->get();

            return view('profile.mypage', [
                'page' => 'buy',
                'purchases' => $purchases,
                'products' => [] // 空にしておく
            ]);
        } else {
            // 出品した商品一覧
            $products = Product::where('user_id', Auth::id())->get();


            return view('profile.mypage', [
                'page' => 'sell',
                'products' => $products,
                'purchases' => [] // 空にしておく
            ]);
        }
    }
}