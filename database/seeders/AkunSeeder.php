<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = [
            [
                'name'      =>'admin',
                'email'     =>'admin@gmail.com',
                'password'  => Hash::make('Admin1234%'),
                'status'    => 2,
                'created_at'=> date('Y-m-d H:i:s')
            ],
            [
                'name'      =>'brayen',
                'email'     =>'brayen@gmail.com',
                // 'password'  => Hash::make('Admin1234%'),
                'password'  => Hash::make('admin123'),
                'status'    => 2,
                'created_at'=> date('Y-m-d H:i:s')
            ],
        ];

        foreach ($user as $value) {
            User::create($value);
        }
    }
}
