<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Product $product)
    {
        // バリデーション
        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $product->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return redirect()->route('products.show', $product->id)
                        ->with('success', 'コメントを投稿しました。');
    }
}