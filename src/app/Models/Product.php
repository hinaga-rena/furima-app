<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'price',
        'brand',
        'description',
        'image',
        'condition',
        'is_sold',
    ];

    protected $casts = [
        'is_sold' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // コメント（多対1）
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    // カテゴリ（多対多）
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    // いいね（多対多 or hasMany）
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/noimage.png');
    }
}