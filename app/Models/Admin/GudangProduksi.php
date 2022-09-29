<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GudangProduksi extends Model
{
    use HasFactory;

    protected $table = 'gudang_produksi';

    protected $fillable = [
        'gudang_produksi_id', 'user_id', 'alamat_gudang_produksi'
    ];

    protected $primaryKey = 'gudang_produksi_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public static function generateGudangProduksiId()
    {
        $gudangProduksiId = DB::table('gudang_produksi')->max('gudang_produksi_id');
        $addZero = '';
        $gudangProduksiId = str_replace("GP", "", $gudangProduksiId);
        $gudangProduksiId = (int) $gudangProduksiId + 1;
        $incrementgudangProduksiId = $gudangProduksiId;

        if (strlen($gudangProduksiId) == 1) {
            $addZero = "000";
        } elseif (strlen($gudangProduksiId) == 2) {
            $addZero = "00";
        } elseif (strlen($gudangProduksiId) == 3) {
            $addZero = "0";
        }

        $newgudangProduksiId = "GP" . $addZero . $incrementgudangProduksiId;
        return $newgudangProduksiId;
    }
}
