<?php

use Illuminate\Database\Seeder;

class RestaurantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Communication::create([
            'category' => 1,
            'name'     => 'thankyou',
            'path'     => '/images/emoticon/',
            'img_name' => 'thankyou.svg'
        ]);

        \App\Communication::create([
            'category' => 1,
            'name'     => 'water',
            'path'     => '/images/emoticon/',
            'img_name' => 'water.svg'
        ]);

        \App\Communication::create([
            'category' => 1,
            'name'     => 'toilet',
            'path'     => '/images/emoticon/',
            'img_name' => 'toilet.svg'
        ]);

        \App\Communication::create([
            'category' => 1,
            'name'     => 'chopsticks',
            'path'     => '/images/emoticon/',
            'img_name' => 'chopsticks.svg'
        ]);

        \App\Communication::create([
            'category' => 1,
            'name'     => 'spoon',
            'path'     => '/images/emoticon/',
            'img_name' => 'spoon.svg'
        ]);

        \App\Communication::create([
            'category' => 1,
            'name'     => 'fork',
            'path'     => '/images/emoticon/',
            'img_name' => 'fork.svg'
        ]);

        \App\Communication::create([
            'category' => 1,
            'name'     => 'bowl',
            'path'     => '/images/emoticon/',
            'img_name' => 'bowl.svg'
        ]);

        \App\Communication::create([
            'category' => 2,
            'name'     => 'menuAdd',
            'path'     => '/images/emoticon/',
            'img_name' => 'menuAdd.svg'
        ]);

        \App\Communication::create([
            'category' => 2,
            'name'     => 'menuChange',
            'path'     => '/images/emoticon/',
            'img_name' => 'menuChange.svg'
        ]);

        \App\Communication::create([
            'category' => 2,
            'name'     => 'menuCancel',
            'path'     => '/images/emoticon/',
            'img_name' => 'menuCancel.svg'
        ]);

        \App\Communication::create([
            'category' => 2,
            'name'     => 'menu',
            'path'     => '/images/emoticon/',
            'img_name' => 'menu.svg'
        ]);

        \App\Communication::create([
            'category' => 2,
            'name'     => 'howTime',
            'path'     => '/images/emoticon/',
            'img_name' => 'howTime.svg'
        ]);

        \App\Communication::create([
            'category' => 3,
            'name'     => 'cashPay',
            'path'     => '/images/emoticon/',
            'img_name' => 'cashPay.svg'
        ]);

        \App\Communication::create([
            'category' => 3,
            'name'     => 'cardPay',
            'path'     => '/images/emoticon/',
            'img_name' => 'cardPay.svg'
        ]);
    }
}
