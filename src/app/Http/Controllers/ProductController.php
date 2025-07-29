<?php

// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()
            ->with('user')
            ->select('products.*');
    // 自分の出品商品を除外（ログイン中のみ）
        if (Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
        }

    // 「マイリスト」タブの場合（like=1）
        if ($request->filled('like') && Auth::check()) {
            $likedProductIds = Auth::user()->likes()->pluck('product_id');
            $query->whereIn('id', $likedProductIds);
        }

    // 検索（部分一致）
        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $products = $query->latest()->get()->unique('id');

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }



    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'condition' => 'required|string',
            'categories' => 'array|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        // 商品保存
        $product = new Product();
        $product->user_id = Auth::id(); // ログインユーザーIDを設定
        $product->name = $request->name;
        $product->brand = $request->brand;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->condition = $request->condition;

        // ファイルアップロード（画像保存）
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = 'storage/' . $path;
        }

        $product->save();

        // カテゴリの紐付け（多対多）
        if ($request->filled('categories')) {
            $product->categories()->sync($request->categories);
        }

        return redirect()->route('products.index')->with('success', '商品を出品しました');
    }

    public function show($id)
    {
        $product = Product::with(['user', 'comments.user', 'likes']) // 関連データも取得
                    ->findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function downloadImage()
{
    $url = 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg';

    // ファイル名をランダムで決定（必要に応じて固定名も可）
    $filename = 'products/' . Str::random(40) . '.jpg';

    // HTTPで画像取得
    $response = Http::get($url);

    // 保存処理
    if ($response->successful()) {
        Storage::disk('public')->put($filename, $response->body());

        return '保存成功: ' . $filename;
    }

    return '保存失敗';
}
}