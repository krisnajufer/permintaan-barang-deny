<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Auth\UserAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeds = (object)[
            [
                "nama" => "Admin",
                "role" => "admin",
                "username" => "admin",
                "password" => bcrypt("admin")
            ]
        ];

        foreach ($seeds as $seed) {
            DB::beginTransaction();
            try {
                $user_id = UserAuth::generateUserId();
                $users = new UserAuth;
                $users->user_id = $user_id;
                $users->slug = Str::random(16);
                $users->nama = $seed["nama"];
                $users->role = $seed["role"];
                $users->username = $seed["username"];
                $users->password = $seed["password"];
                $users->save();
                DB::commit();
            } catch (\Exception $ex) {
                echo $ex->getMessage();
                DB::rollBack();
            }
        }
    }
}
