<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\Gudang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GudangSeeder extends Seeder
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
                "gudang_id" => "G0001",
                "user_id" => "U0002",
                "alamat_gudang" => "Gubeng"
            ]
        ];

        foreach ($seeds as $seed) {
            DB::beginTransaction();
            try {
                $gudang_id = Gudang::generateGudangId();
                $gudang = new Gudang;
                $gudang->gudang_id = $gudang_id;
                $gudang->slug = Str::random(16);
                $gudang->user_id = $seed["user_id"];
                $gudang->alamat_gudang = $seed["alamat_gudang"];
                $gudang->save();
                DB::commit();
            } catch (\Exception $ex) {
                echo $ex->getMessage();
                DB::rollBack();
            }
        }
    }
}
