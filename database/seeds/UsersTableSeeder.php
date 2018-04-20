<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // <-- 사장 6명 , 손님 2명 Data
        \App\User::create([
            'category' => false,
            'name' => 'Take Koichiro',
            'email' => 'take123@example.com',
            'user_id' => 'take123',
            'password' => Hash::make('12345'),
            'gender' => true,
            'country' => 'japan',
            'birthday' => '1977-03-11',
        ]);

        \App\User::create([
            'category' => false,
            'name' => 'Ryu Takeda',
            'email' => 'rrr@example.com',
            'user_id' => 'rrr',
            'password' => Hash::make('123'),
            'gender' => true,
            'country' => 'japan',
            'birthday' => '1988-01-11',
        ]);

        \App\User::create([
            'category' => false,
            'name' => 'Kumiko Tanaka',
            'email' => 'abc@example.com',
            'user_id' => 'abc',
            'password' => Hash::make('abc'),
            'gender' => false,
            'country' => 'japan',
            'birthday' => '1994-09-02',
        ]);

        \App\User::create([
            'category' => false,
            'name' => 'Ryuichi Nakajima',
            'email' => 'sss@example.com',
            'user_id' => 'sss',
            'password' => Hash::make('sss123'),
            'gender' => true,
            'country' => 'japan',
            'birthday' => '1978-09-30',
        ]);

        \App\User::create([
            'category' => false,
            'name' => 'Miya Yoshida',
            'email' => 'www@example.com',
            'user_id' => 'www123',
            'password' => Hash::make('www123'),
            'gender' => false,
            'country' => 'japan',
            'birthday' => '1991-05-22',
        ]);

        \App\User::create([
            'category' => false,
            'name' => 'Ran Ichinoya',
            'email' => 'bbb@example.com',
            'user_id' => 'bbb',
            'password' => Hash::make('bb12'),
            'gender' => true,
            'country' => 'japan',
            'birthday' => '1992-01-11',
        ]);

        \App\User::create([
            'category' => true,
            'name' => 'Hyunsung Lee',
            'email' => 'lhs@example.com',
            'user_id' => 'test',
            'password' => Hash::make('test'),
            'gender' => true,
            'country' => 'korea',
            'birthday' => '1995-02-11',
        ]);

        \App\User::create([
            'category' => true,
            'name' => 'Hobeom Jeon',
            'email' => 'jhb@exmample.com',
            'user_id' => 'hhh',
            'password' => Hash::make('123'),
            'gender' => true,
            'country' => 'korea',
            'birthday' => '1996-07-27',
        ]);
    }
}
