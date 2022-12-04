<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\BarangGudang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BarangGudangSeeder extends Seeder
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
                "barang_gudang_produksi_id" => "BGP00001",
                "quantity_barang_gudang" => 50
            ],
            [
                "barang_gudang_produksi_id" => "BGP00002",
                "quantity_barang_gudang" => 50
            ],
            [
                "barang_gudang_produksi_id" => "BGP00003",
                "quantity_barang_gudang" => 50
            ],
            [
                "barang_gudang_produksi_id" => "BGP00004",
                "quantity_barang_gudang" => 50
            ],
            [
                "barang_gudang_produksi_id" => "BGP00005",
                "quantity_barang_gudang" => 50
            ],
            [
                "barang_gudang_produksi_id" => "BGP00006",
                "quantity_barang_gudang" => 50
            ],
            [
                "barang_gudang_produksi_id" => "BGP00007",
                "quantity_barang_gudang" => 50
            ],
            [
                "barang_gudang_produksi_id" => "BGP00008",
                "quantity_barang_gudang" => 50
            ],
            [
                "barang_gudang_produksi_id" => "BGP00009",
                "quantity_barang_gudang" => 50
            ],
            [
                "barang_gudang_produksi_id" => "BGP00010",
                "quantity_barang_gudang" => 50
            ],
            [
                "barang_gudang_produksi_id" => "BGP00011",
                "quantity_barang_gudang" => 50
            ],
            [
                "barang_gudang_produksi_id" => "BGP00012",
                "quantity_barang_gudang" => 50
            ],
        ];

        foreach ($seeds as $seed) {
            DB::beginTransaction();
            try {
                $barang_gudang_id = "G0001" . $seed["barang_gudang_produksi_id"];
                $barang_gudang_produksi = new BarangGudang;
                $barang_gudang_produksi->barang_gudang_id = $barang_gudang_id;
                $barang_gudang_produksi->barang_gudang_produksi_id = $seed["barang_gudang_produksi_id"];
                $barang_gudang_produksi->slug = Str::random(16);
                $barang_gudang_produksi->gudang_id = "G0001";
                $barang_gudang_produksi->quantity_barang_gudang = $seed["quantity_barang_gudang"];
                $barang_gudang_produksi->save();
                DB::commit();
            } catch (\Exception $ex) {
                echo $ex->getMessage();
                DB::rollBack();
            }
        }
    }
}
