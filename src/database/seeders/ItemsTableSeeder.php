<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use Illuminate\Support\Facades\Schema;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        \App\Models\Item::truncate();
        Schema::enableForeignKeyConstraints();

        \App\Models\Item::insert([
            [
                'user_id' => 1,
                'name' => '腕時計',
                'brand_name' => 'Rolax',
                'status' => '良好',
                'price' => 15000,
                'description' => 'シンプルで使いやすい腕時計です。',
                'image_path' => 'images/items/Clock.jpg',
                'likes_count' => 3,
                'comments_count' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'name' => 'HDD',
                'brand_name' => '西芝',
                'status' => '目立った傷や汚れなし',
                'price' => 5000,
                'description' => '大容量の外付けHDDです。',
                'image_path' => 'images/items/HDD.jpg',
                'likes_count' => 0,
                'comments_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'name' => '玉ねぎ3束',
                'brand_name' => 'なし',
                'status' => 'やや傷や汚れあり',
                'price' => 300,
                'description' => '新鮮な玉ねぎ3束のセット',
                'image_path' => 'images/items/Onion.jpg',
                'likes_count' => 1,
                'comments_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'name' => '革靴',
                'brand_name' => 'null',
                'status' => '状態が悪い',
                'price' => 4000,
                'description' => 'クラシックなデザインの革靴',
                'image_path' => 'images/items/Shoes.jpg',
                'likes_count' => 1,
                'comments_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'name' => 'ノートPC',
                'brand_name' => 'null',
                'status' => '良好',
                'price' => 45000,
                'description' => '高性能なノートパソコン',
                'image_path' => 'images/items/PC.jpg',
                'likes_count' => 5,
                'comments_count' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'name' => 'マイク',
                'brand_name' => 'なし',
                'status' => '目立った傷や汚れなし',
                'price' => 8000,
                'description' => '高音質のレコーディング用マイク',
                'image_path' => 'images/items/Mic.jpg',
                'likes_count' => 4,
                'comments_count' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'name' => 'ショルダーバッグ',
                'brand_name' => 'null',
                'status' => 'やや傷や汚れあり',
                'price' => 15000,
                'description' => 'おしゃれなショルダーバッグ',
                'image_path' => 'images/items/Bag.jpg',
                'likes_count' => 2,
                'comments_count' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'name' => 'タンブラー',
                'brand_name' => 'なし',
                'status' => '状態が悪い',
                'price' => 500,
                'description' => '使いやすいタンブラー',
                'image_path' => 'images/items/Tumbler.jpg',
                'likes_count' => 0,
                'comments_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'name' => 'コーヒーミル',
                'brand_name' => 'Starbacks',
                'status' => '良好',
                'price' => 4000,
                'description' => '手動のコーヒーミル',
                'image_path' => 'images/items/Coffee.jpg',
                'likes_count' => 1,
                'comments_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'name' => 'メイクセット',
                'brand_name' => 'null',
                'status' => '目立った傷や汚れなし',
                'price' => 2500,
                'description' => '便利なメイクアップセット',
                'image_path' => 'images/items/Makeup.jpg',
                'likes_count' => 1,
                'comments_count' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
