<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function myList()
    {
        $user = Auth::user();

        $products = $user->likes()->with('product')
            ->get()
            ->pluck('product')
            ->filter();

        return view('products.mylist', compact('products'));
    }
    public function toggle(Product $product)
    {
        $user = Auth::user();

        $like = Like::where('user_id', $user->id)
                    ->where('product_id', $product->id)
                    ->first();

        if ($like) {
            $like->delete(); // いいね解除
        } else {
            Like::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }

        return back(); // 前のページに戻る
    }
}