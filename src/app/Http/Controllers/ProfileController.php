<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function storeSetup(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'zip' => 'nullable|regex:/^\d{3}-?\d{4}$/',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|max:2048',
            'selected_image' => 'nullable|string',
        ]);

        // プロフィール画像がアップロードされた場合
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = 'storage/' . $path;
        }elseif ($request->filled('selected_image')) {
            // 事前画像が選ばれている場合
            $user->profile_image = $request->selected_image;
        }

        // 入力値を保存
        $user->name = $request->name;
        $user->zip = $request->zip;
        $user->address = $request->address;
        $user->building = $request->building;
        $user->save();

        return redirect()->route('mypage')->with('status', 'プロフィールを設定しました。');
    }

    public function setup()
    {
        $user = Auth::user();

        // public/storage/profile_images ディレクトリの画像一覧を取得
        $files = \Storage::disk('public')->files('profile_images');
        $predefinedImages = collect($files)
            ->filter(fn($file) => preg_match('/\.(jpg|jpeg|png|gif)$/i', $file))
            ->map(fn($file) => asset('storage/' . $file))
            ->values();

        return view('profile.setup', compact('user', 'predefinedImages'));
    }

    public function edit()
    {
        $user = Auth::user();

        // public/storage/profile_images ディレクトリの画像一覧を取得
        $files = \Storage::disk('public')->files('profile_images');
        $predefinedImages = collect($files)
            ->filter(fn($file) => preg_match('/\.(jpg|jpeg|png|gif)$/i', $file))
            ->map(fn($file) => asset('storage/' . $file))
            ->values();

        return view('profile.setup', compact('user', 'predefinedImages'));
    }

    public function editAddress()
    {
        $user = auth()->user();
        return view('profile.edit_address', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'zip' => 'nullable|regex:/^\d{3}-?\d{4}$/',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|max:2048',
            'selected_image' => 'nullable|string',
        ]);

        // 1. 古い画像の削除とアップロード
        if ($request->hasFile('profile_image')) {
            // 古い画像がある場合は削除
            if ($user->profile_image && Storage::disk('public')->exists(str_replace('storage/', '', $user->profile_image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $user->profile_image));
            }

            // 新しい画像を保存
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = 'storage/' . $path;

        } elseif ($request->filled('selected_image')) {
        // 事前画像を選択している場合（アップロードがなければ）
        $user->profile_image = $request->selected_image;
        }

        // 2. ユーザー情報を更新
        $user->name = $request->name;
        $user->zip = $request->zip;
        $user->address = $request->address;
        $user->building = $request->building;
        $user->save();

        // 3. ログを出力（任意）
        Log::info('プロフィールが更新されました。', [
            'user_id' => $user->id,
            'updated_by' => Auth::id(),
            'updated_fields' => $request->only(['name', 'zip', 'address', 'building']),
        ]);

        // 4. 成功時にマイページへリダイレクト
        return redirect()->route('mypage')->with('status', 'プロフィールを更新しました。');

    }
}