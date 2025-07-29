<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DownloadProductImages extends Command
{
    protected $signature = 'download:product-images';
    protected $description = '外部URLから商品画像をダウンロードしてstorageに保存する';

    public function handle()
    {
        $imageUrls = [
            'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
            'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
            'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
            'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
            'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhBfolqi8tlqY4yVXJbvVGCJwT0c7ADx9Mv8VCS7kcQDHplaYitvwd3NSDD3lLLky5Et_mBTDiWGKEYvIW9y28CpDjIzwcd0f6O2ss0MZkY7PO8bX7VHiaFy2Zxv4O7QsWIVhwQILyWQYo/s800/youngwoman_37.png',
        ];

        foreach ($imageUrls as $url) {
            try {
                $imageContents = file_get_contents($url);
                $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
                $filename = 'products/' . Str::uuid() . '.' . $extension;

                Storage::disk('public')->put($filename, $imageContents);

                $this->info("Saved: $filename");
            } catch (\Exception $e) {
                $this->error("Failed to save image: $url");
            }
        }

        $this->info('全ての画像保存処理が完了しました');
        return 0;
    }
}