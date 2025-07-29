<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create();

        $products = [
            [
                'user_id'     => $user->id,
                'name' => '腕時計',
                'price' => 15000,
                'brand' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'image' => 'products/XZVPvU8Yc3hl8v9Emko8h3kd0iZSZaUKXcmkKcZD.jpg',
                'condition' => '良好',
            ],
            [
                'user_id'     => $user->id,
                'name' => 'HDD',
                'price' => 5000,
                'brand' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'image' => 'products/oTnugDZUhmeYDnWPd7qshTyvELIHKhoUX2gd7iav.jpg',
                'condition' => '目立った傷や汚れなし',
            ],
            [
                'user_id'     => $user->id,
                'name' => '玉ねぎ3束',
                'price' => 300,
                'brand' => 'なし',
                'description' => '新鮮な玉ねぎ3束のセット',
                'image' => 'products/onion_bundle.jpg',
                'condition' => 'やや傷や汚れあり',
            ],
            [
                'user_id'     => $user->id,
                'name' => '革靴',
                'price' => 4000,
                'brand' => '',
                'description' => 'クラシックなデザインの革靴',
                'image' => 'products/1Gs0OFpZuRGtqQvMyuFDljC4Jmyk8Rjf42r1Mt61.jpg',
                'condition' => '状態が悪い',
            ],
            [
                'user_id'     => $user->id,
                'name' => 'ノートPC',
                'price' => 45000,
                'brand' => '',
                'description' => '高性能なノートパソコン',
                'image' => 'products/a6naYE9ZGeo0nqbfLEWjeKkwknz1C8O3hbmzvlQn.jpg',
                'condition' => '良好',
            ],
            [
                'user_id'     => $user->id,
                'name' => 'マイク',
                'price' => 8000,
                'brand' => 'なし',
                'description' => '高音質のレコーディング用マイク',
                'image' => 'products/NRmIFD4dcwkdfaaSqHfMYJU5qfNRh7IC3r3kjalT.jpg',
                'condition' => '目立った傷や汚れなし',
            ],
            [
                'user_id'     => $user->id,
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'brand' => '',
                'description' => 'おしゃれなショルダーバッグ',
                'image' => 'products/kQx3LkfqjTCJxXUW1NNtMvuAcj9DLO7tagFKVMsg.jpg',
                'condition' => 'やや傷や汚れあり',
            ],
            [
                'user_id'     => $user->id,
                'name' => 'タンブラー',
                'price' => 500,
                'brand' => 'なし',
                'description' => '使いやすいタンブラー',
                'image' => 'products/6eI4MQhcApNlH4SU5l71JdiF6qKcpAcZagIx1Cqw.jpg',
                'condition' => '状態が悪い',
            ],
            [
                'user_id'     => $user->id,
                'name' => 'コーヒーミル',
                'price' => 4000,
                'brand' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'image' => 'products/PLz6DOhlJedn03ygBlWRTtsOXuYhzER2QIRhP2Ow.jpg',
                'condition' => '良好',
            ],
            [
                'user_id'     => $user->id,
                'name' => 'メイクセット',
                'price' => 2500,
                'brand' => '',
                'description' => '便利なメイクアップセット',
                'image' => 'products/KEsqkzX2onhGCXyHFiv56Qv9RuAXAOzPf0byvEBd.jpg',
                'condition' => '目立った傷や汚れなし',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}