<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Permintaan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\Admin\DetailPermintaan;

class PermintaanController extends Controller
{
    public function userAuth()
    {
        $user = Auth::guard('user')->user();

        return $user;
    }

    public function index()
    {
        $user = $this->userAuth();
        if (empty($count_persetujuan)) {
            $count_persetujuan = [];
        }
        $permintaans = DB::table('permintaan as p')
            ->join('users as u', 'p.user_id', '=', 'u.user_id')
            ->select('p.permintaan_id', 'p.slug', 'u.nama', 'p.tanggal_permintaan', 'p.status_permintaan')
            ->get();

        return view('admin.pages.permintaan.index', compact('user', 'permintaans'));
    }

    public function create()
    {
        $user = $this->userAuth();
        $permintaan_id = Permintaan::generatePermintaanId();
        $barangs = DB::table('barang_gudang as bg')
            ->join('barang_gudang_produksi as bgp', 'bg.barang_gudang_produksi_id', '=', 'bgp.barang_gudang_produksi_id')
            ->join('gudang as g', 'bg.gudang_id', '=', 'g.gudang_id')
            ->join('users as u', 'g.user_id', '=', 'u.user_id')
            ->select('bg.barang_gudang_id', 'bgp.barang_gudang_produksi_id', 'bgp.nama_barang', 'bg.slug', 'u.nama')
            ->get();

        return view('admin.pages.permintaan.create', compact('user', 'barangs', 'permintaan_id'));
    }

    public function store(Request $request)
    {
        $user = $this->userAuth();
        $permintaan_id = $request->get('id_permintaan');
        $data_permintaan = json_decode($request->permintaan);
        $permintaan = new Permintaan;
        $permintaan->permintaan_id = $permintaan_id;
        $permintaan->slug = Str::random(16);
        $permintaan->user_id = $user->user_id;
        $permintaan->tanggal_permintaan = Carbon::now();
        $permintaan->status_permintaan = "Pending";
        $permintaan->save();
        foreach ($data_permintaan as $key => $data) {
            $detail = new DetailPermintaan;
            $detail->permintaan_id = $permintaan_id;
            $detail->barang_gudang_produksi_id = $data->bgp_id;
            $detail->jumlah_permintaan = $data->quantity;
            $detail->save();
        }
        return response()->json(array(), 200);
    }

    public function show($slug)
    {
        // session()->forget("temporary_pengiriman");
        $user = $this->userAuth();
        $detail_permintaan = DB::table('detail_permintaan as dp')
            ->join('permintaan as p', 'dp.permintaan_id', '=', 'p.permintaan_id')
            ->join('barang_gudang_produksi as bgp', 'dp.barang_gudang_produksi_id', '=', 'bgp.barang_gudang_produksi_id')
            ->where('p.slug', $slug)
            ->get();

        $count_detail = DB::table('detail_permintaan as dp')
            ->join('permintaan as p', 'dp.permintaan_id', '=', 'p.permintaan_id')
            ->join('barang_gudang_produksi as bgp', 'dp.barang_gudang_produksi_id', '=', 'bgp.barang_gudang_produksi_id')
            ->where('p.slug', $slug)
            ->count();

        $permintaan = DB::table('permintaan')->where('slug', $slug)->first();

        $temporary_pengiriman = session("temporary_pengiriman");
        $tmp = (array) $temporary_pengiriman;
        $count_temporary = count($tmp);

        return view('admin.pages.permintaan.detail', compact('user', 'detail_permintaan', 'permintaan', 'temporary_pengiriman', 'count_detail', 'count_temporary'));
    }
}
