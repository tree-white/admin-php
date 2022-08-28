<?php

namespace Database\Seeders;

use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(20)->create();
        User::factory(3)->has(Site::factory())->create();
        $user = User::first();
        $user->email = 'trwite@treewhite.com';
        $user->name = '楷哥哥';
        $user->mobile = '18888888888';
        $user->password = Hash::make('admin888');
        $user->save();
    }
}
