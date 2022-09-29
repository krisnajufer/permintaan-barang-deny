<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BarangGudang extends Model
{
    use HasFactory;

    protected $table = 'barang_gudang';

    protected $fillable = [
        'barang_gudang_id', 'slug', 'gudang_id', 'nama_barang', 'barang_gudang_produksi_id', 'quantity_barang_gudang'
    ];

    protected $primaryKey = 'barang_gudang_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public static function generateGudangId()
    {
        $barangGudangId = DB::table('barang_gudang')->max('barang_gudang_id');
        $addZero = '';
        $barangGudangId = str_replace("BG", "", $barangGudangId);
        $barangGudangId = (int) $barangGudangId + 1;
        $incrementBarangGudangId = $barangGudangId;

        if (strlen($barangGudangId) == 1) {
            $addZero = "0000";
        } elseif (strlen($barangGudangId) == 2) {
            $addZero = "000";
        } elseif (strlen($barangGudangId) == 3) {
            $addZero = "00";
        } elseif (strlen($barangGudangId) == 4) {
            $addZero = "0";
        }

        $newBarangGudangId = "BG" . $addZero . $incrementBarangGudangId;
        return $newBarangGudangId;
    }
}
