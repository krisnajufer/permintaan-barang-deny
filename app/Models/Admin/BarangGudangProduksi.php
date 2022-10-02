<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BarangGudangProduksi extends Model
{
    use HasFactory;

    protected $table = 'barang_gudang_produksi';

    protected $fillable = [
        'barang_gudang_produksi_id', 'slug', 'gudang_produksi_id', 'nama_barang'
    ];

    protected $primaryKey = 'barang_gudang_produksi_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public static function generateBarangGudangProduksiId()
    {
        $barangGudangProduksiId = DB::table('barang_gudang_produksi')->max('barang_gudang_produksi_id');
        $addZero = '';
        $barangGudangProduksiId = str_replace("BGP", "", $barangGudangProduksiId);
        $barangGudangProduksiId = (int) $barangGudangProduksiId + 1;
        $incrementBarangGudangProduksiId = $barangGudangProduksiId;

        if (strlen($barangGudangProduksiId) == 1) {
            $addZero = "0000";
        } elseif (strlen($barangGudangProduksiId) == 2) {
            $addZero = "000";
        } elseif (strlen($barangGudangProduksiId) == 3) {
            $addZero = "00";
        } elseif (strlen($barangGudangProduksiId) == 4) {
            $addZero = "0";
        }

        $newBarangGudangProduksiId = "BGP" . $addZero . $incrementBarangGudangProduksiId;
        return $newBarangGudangProduksiId;
    }
}
