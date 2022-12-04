<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\BarangGudangProduksi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BarangGudangProduksiSeeder extends Seeder
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
                "nama_barang" => "Alumunium Holo 1x1 Inch",
            ],
            [
                "nama_barang" => "Alumunium Tipe U 3/8",
            ],
            [
                "nama_barang" => "Kaca Samping 50cm x 180cm",
            ],
            [
                "nama_barang" => "Kaca Depan 1m x 180cm",
            ],
            [
                "nama_barang" => "Kaca Atas 1m x 50cm",
            ],
            [
                "nama_barang" => "Kawat Ram Belakang 1m x 180cm",
            ],
            [
                "nama_barang" => "Kawat Ram Bawah 1m x 50cm",
            ],
            [
                "nama_barang" => "Alumunium Holo 1/2 x 1",
            ],
            [
                "nama_barang" => "Alumunium Tipe Pipa 3/8",
            ],
            [
                "nama_barang" => "Kaca Atas Etalase ukuran 1m x 40cm",
            ],
            [
                "nama_barang" => "Kaca Tatakan Etalase ukuran 80cm x 30cm",
            ],
            [
                "nama_barang" => "Kaca Depan Etalase ukuran 1m x 50cm",
            ],
        ];

        foreach ($seeds as $seed) {
            DB::beginTransaction();
            try {
                $barang_gudang_produksi_id = BarangGudangProduksi::generateBarangGudangProduksiId();
                $barang_gudang_produksi = new BarangGudangProduksi;
                $barang_gudang_produksi->barang_gudang_produksi_id = $barang_gudang_produksi_id;
                $barang_gudang_produksi->slug = Str::random(16);
                $barang_gudang_produksi->gudang_produksi_id = "GP0001";
                $barang_gudang_produksi->nama_barang = $seed["nama_barang"];
                $barang_gudang_produksi->save();
                DB::commit();
            } catch (\Exception $ex) {
                echo $ex->getMessage();
                DB::rollBack();
            }
        }
    }
}
