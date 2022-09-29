<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Gudang extends Model
{
    use HasFactory;

    protected $table = 'gudang';

    protected $fillable = [
        'gudang_id', 'user_id', 'alamat_gudang'
    ];

    protected $primaryKey = 'gudang_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public static function generateGudangId()
    {
        $gudangId = DB::table('gudang')->max('gudang_id');
        $addZero = '';
        $gudangId = str_replace("G", "", $gudangId);
        $gudangId = (int) $gudangId + 1;
        $incrementgudangId = $gudangId;

        if (strlen($gudangId) == 1) {
            $addZero = "000";
        } elseif (strlen($gudangId) == 2) {
            $addZero = "00";
        } elseif (strlen($gudangId) == 3) {
            $addZero = "0";
        }

        $newgudangId = "G" . $addZero . $incrementgudangId;
        return $newgudangId;
    }
}
