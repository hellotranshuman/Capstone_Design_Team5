<?php

use Illuminate\Database\Seeder;

class UploadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Upload::create([
            'shop_id' => 1,
            'filename' => '1_titleImg.jpg',
            'path' => '/images/1/'
        ]);

        \App\Upload::create([
            'shop_id' => 1,
            'filename' => '1_galleryImg_0.jpg',
            'path' => '/images/1/'
        ]);

        \App\Upload::create([
            'shop_id' => 1,
            'filename' => '1_galleryImg_1.jpg',
            'path' => '/images/1/'
        ]);

        \App\Upload::create([
            'shop_id' => 2,
            'filename' => '2_titleImg.jpg',
            'path' => '/images/2/'
        ]);

        \App\Upload::create([
            'shop_id' => 3,
            'filename' => '3_titleImg.jpg',
            'path' => '/images/3/'
        ]);

        \App\Upload::create([
            'shop_id' => 3,
            'filename' => '3_galleryImg_0.jpg',
            'path' => '/images/3/'
        ]);

        \App\Upload::create([
            'shop_id' => 3,
            'filename' => '3_galleryImg_1.jpg',
            'path' => '/images/3/'
        ]);

        \App\Upload::create([
            'shop_id' => 3,
            'filename' => '3_galleryImg_2.jpg',
            'path' => '/images/3/'
        ]);

        \App\Upload::create([
            'shop_id' => 4,
            'filename' => '4_titleImg.jpg',
            'path' => '/images/4/'
        ]);

        \App\Upload::create([
            'shop_id' => 4,
            'filename' => '4_galleryImg_0.jpg',
            'path' => '/images/4/'
        ]);

        \App\Upload::create([
            'shop_id' => 4,
            'filename' => '4_galleryImg_1.jpg',
            'path' => '/images/4/'
        ]);

        \App\Upload::create([
            'shop_id' => 5,
            'filename' => '5_titleImg.jpg',
            'path' => '/images/5/'
        ]);

        \App\Upload::create([
            'shop_id' => 5,
            'filename' => '5_galleryImg_0.jpg',
            'path' => '/images/5/'
        ]);

        \App\Upload::create([
            'shop_id' => 5,
            'filename' => '5_galleryImg_1.jpg',
            'path' => '/images/5/'
        ]);

        \App\Upload::create([
            'shop_id' => 6,
            'filename' => '6_titleImg.jpg',
            'path' => '/images/6/'
        ]);

        \App\Upload::create([
            'shop_id' => 6,
            'filename' => '6_galleryImg_0.jpg',
            'path' => '/images/6/'
        ]);

        \App\Upload::create([
            'shop_id' => 6,
            'filename' => '6_galleryImg_1.jpg',
            'path' => '/images/6/'
        ]);

        \App\Upload::create([
            'shop_id' => 6,
            'filename' => '6_galleryImg_2.jpg',
            'path' => '/images/6/'
        ]);

        \App\Upload::create([
            'shop_id' => 6,
            'filename' => '6_galleryImg_3.jpg',
            'path' => '/images/6/'
        ]);
    }
}