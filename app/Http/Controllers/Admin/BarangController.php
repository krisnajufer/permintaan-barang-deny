<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\BarangGudang;
use App\Models\Admin\BarangGudangProduksi;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    public function userAuth()
    {
        $user = Auth::guard('user')->user();

        return $user;
    }

    public function index()
    {
        $users = $this->userAuth();
        if ($users->role == 'nonproduksi') {
            $barangs = DB::table('barang_gudang as bg')
                ->join('barang_gudang_produksi as bgp', 'bg.barang_gudang_produksi_id', '=', 'bgp.barang_gudang_produksi_id')
                ->join('gudang as g', 'bg.gudang_id', '=', 'g.gudang_id')
                ->join('users as u', 'g.user_id', '=', 'u.user_id')
                ->select('bg.barang_gudang_id as barang_gudang_id', 'bg.slug as slug_barang', 'u.nama as nama_gudang', 'bgp.nama_barang as nama_barang', 'bg.quantity_barang_gudang as quantity')
                ->where('u.user_id', $users->user_id)
                ->get();
        } elseif ($users->role == 'produksi') {
            $barangs = NULL;
        }

        return view('admin.pages.barang.index', compact('barangs', 'users'));
    }

    public function getBarang(Request $request)
    {
        $users = $this->userAuth();
        $role = $request->role;
        if ($role == 'produksi') {
            if ($users->role == 'produksi') {
                $barangs = DB::table('barang_gudang_produksi as bgp')
                    ->join('gudang_produksi as gp', 'bgp.gudang_produksi_id', '=', 'gp.gudang_produksi_id')
                    ->join('users as u', 'gp.user_id', '=', 'u.user_id')
                    ->select('bgp.barang_gudang_produksi_id as barang_gudang_id', 'bgp.slug as slug_barang', 'u.nama as nama_gudang', 'bgp.nama_barang as nama_barang')
                    ->where('u.user_id', $users->user_id)
                    ->get();
            } else {
                $barangs = DB::table('barang_gudang_produksi as bgp')
                    ->join('gudang_produksi as gp', 'bgp.gudang_produksi_id', '=', 'gp.gudang_produksi_id')
                    ->join('users as u', 'gp.user_id', '=', 'u.user_id')
                    ->select('bgp.barang_gudang_produksi_id as barang_gudang_id', 'bgp.slug as slug_barang', 'u.nama as nama_gudang', 'bgp.nama_barang as nama_barang')
                    ->get();
            }
            return response()->json(array(
                'barangs' => $barangs,
            ), 200);
        } elseif ($role == 'nonproduksi') {
            if ($users->role == 'nonproduksi') {
                $barangs = DB::table('barang_gudang as bg')
                    ->join('barang_gudang_produksi as bgp', 'bg.barang_gudang_produksi_id', '=', 'bgp.barang_gudang_produksi_id')
                    ->join('gudang as g', 'bg.gudang_id', '=', 'g.gudang_id')
                    ->join('users as u', 'g.user_id', '=', 'u.user_id')
                    ->select('bg.barang_gudang_id as barang_gudang_id', 'bg.slug as slug_barang', 'u.nama as nama_gudang', 'bgp.nama_barang as nama_barang', 'bg.quantity_barang_gudang as quantity')
                    ->where('u.user_id', $users->user_id)
                    ->get();
            } else {
                $barangs = DB::table('barang_gudang as bg')
                    ->join('barang_gudang_produksi as bgp', 'bg.barang_gudang_produksi_id', '=', 'bgp.barang_gudang_produksi_id')
                    ->join('gudang as g', 'bg.gudang_id', '=', 'g.gudang_id')
                    ->join('users as u', 'g.user_id', '=', 'u.user_id')
                    ->select('bg.barang_gudang_id as barang_gudang_id', 'bg.slug as slug_barang', 'u.nama as nama_gudang', 'bgp.nama_barang as nama_barang', 'bg.quantity_barang_gudang as quantity')
                    ->get();
            }
            return response()->json(array(
                'barangs' => $barangs,
            ), 200);
        }
    }
}
