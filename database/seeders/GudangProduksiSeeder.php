<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\GudangProduksi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class GudangProduksiSeeder extends Seeder
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
                "user_id" => "U0001",
                "alamat_gudang_produksi" => "Mejoyo"
            ]
        ];

        foreach ($seeds as $seed) {
            DB::beginTransaction();
            try {
                $gudang_produksi_id = GudangProduksi::generateGudangProduksiId();
                $gudang_produksi = new GudangProduksi;
                $gudang_produksi->gudang_produksi_id = $gudang_produksi_id;
                $gudang_produksi->slug = Str::random(16);
                $gudang_produksi->user_id = $seed["user_id"];
                $gudang_produksi->alamat_gudang_produksi = $seed["alamat_gudang_produksi"];
                $gudang_produksi->save();
                DB::commit();
            } catch (\Exception $ex) {
                echo $ex->getMessage();
                DB::rollBack();
            }
        }
    }
}
