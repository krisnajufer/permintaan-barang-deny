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
}
