<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class Permintaan extends Model
{
    use HasFactory;

    protected $table = 'permintaan';

    protected $fillable = [
        'permintaan_id', 'slug', 'user_id', 'tanggal_permintaan', 'status_permintaan'
    ];

    protected $primaryKey = 'permintaan_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public static function generatePermintaanId()
    {
        $permintaanId = DB::table('permintaan')->max('permintaan_id');
        $now = date_format(Carbon::now(), 'Y');
        $addZero = '';
        $permintaanId = str_replace("PM." . $now . '.', "", $permintaanId);
        $permintaanId = (int) $permintaanId + 1;
        $incrementpermintaanId = $permintaanId;

        if (strlen($permintaanId) == 1) {
            $addZero = "0000";
        } elseif (strlen($permintaanId) == 2) {
            $addZero = "000";
        } elseif (strlen($permintaanId) == 3) {
            $addZero = "00";
        } elseif (strlen($permintaanId) == 4) {
            $addZero = "0";
        }

        $newPermintaanId = "PM" . '.' . $now . '.' . $addZero . $incrementpermintaanId;
        return $newPermintaanId;
    }
}
