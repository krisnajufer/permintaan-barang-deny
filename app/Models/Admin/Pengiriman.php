<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class Pengiriman extends Model
{
    use HasFactory;
    protected $table = 'pengiriman';

    protected $fillable = [
        'pengiriman_id', 'slug', 'permintaan_id', 'tanggal_pengiriman', 'tanggal_penerimaan'
    ];

    protected $primaryKey = 'pengiriman_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public static function generatePengirimanId()
    {
        $pengirimanId = DB::table('pengiriman')->max('pengiriman_id');
        $now = date_format(Carbon::now(), 'Y');
        $addZero = '';
        $pengirimanId = str_replace("PR." . $now . '.', "", $pengirimanId);
        $pengirimanId = (int) $pengirimanId + 1;
        $incrementpengirimanId = $pengirimanId;

        if (strlen($pengirimanId) == 1) {
            $addZero = "0000";
        } elseif (strlen($pengirimanId) == 2) {
            $addZero = "000";
        } elseif (strlen($pengirimanId) == 3) {
            $addZero = "00";
        } elseif (strlen($pengirimanId) == 4) {
            $addZero = "0";
        }

        $newPengirimanId = "PR" . '.' . $now . '.' . $addZero . $incrementpengirimanId;
        return $newPengirimanId;
    }
}
