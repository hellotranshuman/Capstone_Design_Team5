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
        \App\Restaurant::create([
            'name' => 'うめっちゃが食堂 福岡パルコ店',
            'explanation' => 'うめっちゃが食堂 福岡パルコ店',
            'user_num' => 1,
            'type' => '居酒屋',
            'phone' => '050-5595-3589',
            'dodobuken' => '福岡',
            'cities' => '福岡市中央区',
            'address' => '天神2-11-1 福岡パルコ 本館・増床エリア B1F',
            'lunch_open' => '11:00:00',
            'lunch_close' => '15:00:00',
            'lunch_lo' => '14:00:00',
            'dinner_open' => '17:00:00',
            'dinner_close' => '23:00:00',
            'dinner_lo' => '22:00:00',
            'payment' => 'card',
            'seat_num' => 37,
            'children' => true,
            'pet' => true,
            'parking' => true,
            'smoking' => true,
            'privateroom' => true,
        ]);

        \App\Restaurant::create([
            'name' => '熟成華味鳥と釜めし 喜集',
            'explanation' => '熟成華味鳥と釜めし 喜集',
            'user_num' => 2,
            'type' => '魚介料理',
            'phone' => '050-5593-9021',
            'dodobuken' => '福岡',
            'cities' => '福岡市中央区',
            'address' => '春吉3-21-28 ロマネスクリゾートクラブ西中洲 4F',
            'lunch_open' => '11:30:00',
            'lunch_close' => '14:00:00',
            'lunch_lo' => '13:00:00',
            'dinner_open' => '16:00:00',
            'dinner_close' => '24:00:00',
            'dinner_lo' => '23:00:00',
            'payment' => 'カード可',
            'seat_num' => 80,
            'children' => true,
            'pet' => true,
            'parking' => true,
            'smoking' => true,
            'privateroom' => true,
        ]);

        \App\Restaurant::create([
            'name' => '串揚げと季節のお料理 さとう 公式情報',
            'explanation' => '串揚げと季節のお料理 さとう 公式情報',
            'user_num' => 3,
            'type' => '居酒屋',
            'phone' => '050-5593-8086',
            'dodobuken' => '福岡',
            'cities' => '福岡市中央区',
            'address' => '渡辺通5-3-23-1',
            'lunch_open' => '11:00:00',
            'lunch_close' => '14:00:00',
            'lunch_lo' => '13:00:00',
            'dinner_open' => '17:30:00',
            'dinner_close' => '03:00:00',
            'dinner_lo' => '02:00:00',
            'payment' => 'カード可',
            'seat_num' => 26,
            'children' => true,
            'pet' => true,
            'parking' => true,
            'smoking' => true,
            'privateroom' => true,
        ]);

        \App\Restaurant::create([
            'name' => '博多 なぎの木 西中洲',
            'explanation' => '博多 なぎの木 西中洲',
            'user_num' => 4,
            'type' => 'ダイニングバー',
            'phone' => '050-5595-3573',
            'dodobuken' => '福岡',
            'cities' => '福岡市中央区',
            'address' => '西中洲10-1',
            'lunch_open' => '11:00:00',
            'lunch_close' => '15:00:00',
            'lunch_lo' => '14:00:00',
            'dinner_open' => '17:00:00',
            'dinner_close' => '23:00:00',
            'dinner_lo' => '22:00:00',
            'payment' => 'カード可',
            'seat_num' => 60,
            'children' => true,
            'pet' => true,
            'parking' => true,
            'smoking' => true,
            'privateroom' => true,
        ]);

        \App\Restaurant::create([
            'name' => '禅',
            'explanation' => '禅',
            'user_num' => 5,
            'type' => '和食',
            'phone' => '050-5594-6259',
            'dodobuken' => '福岡',
            'cities' => '福岡市中央区',
            'address' => '渡辺通5丁目24-37 代五レジデンス江崎',
            'lunch_open' => '11:30:00',
            'lunch_close' => '14:00:00',
            'lunch_lo' => '13:00:00',
            'dinner_open' => '17:30:00',
            'dinner_close' => '22:00:00',
            'dinner_lo' => '21:00:00',
            'payment' => 'カード不可',
            'seat_num' => 13,
            'children' => true,
            'pet' => true,
            'parking' => true,
            'smoking' => true,
            'privateroom' => true,
        ]);

        \App\Restaurant::create([
            'name' => 'カドノカシーワ',
            'explanation' => 'カドノカシーワ',
            'user_num' => 6,
            'type' => 'おでん',
            'phone' => '050-5592-9057',
            'dodobuken' => '福岡',
            'cities' => '福岡市中央区',
            'address' => '西中洲11-9 小嶋ビル 1F',
            'lunch_open' => '11:00:00',
            'lunch_close' => '15:00:00',
            'lunch_lo' => '14:00:00',
            'dinner_open' => '17:00:00',
            'dinner_close' => '24:00:00',
            'dinner_lo' => '01:00:00',
            'payment' => 'カード可',
            'seat_num' => 30,
            'children' => true,
            'pet' => true,
            'parking' => true,
            'smoking' => true,
            'privateroom' => true,
        ]);
    }
}
