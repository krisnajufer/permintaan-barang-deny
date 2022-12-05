<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Pengiriman;
use App\Models\Admin\DetailPengiriman;
use App\Models\Admin\Permintaan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PengirimanController extends Controller
{
    public function userAuth()
    {
        $user = Auth::guard('user')->user();

        return $user;
    }

    public function index()
    {
        $user = $this->userAuth();
        $pengiriman = DB::table('pengiriman as pr')
            ->join('permintaan as pm', 'pr.permintaan_id', '=', 'pm.permintaan_id')
            ->get();

        return view('admin.pages.pengiriman.index', compact('pengiriman', 'user'));
    }

    public function create($permintaan_id, $barang_gudang_produksi_id)
    {
        $user = $this->userAuth();
        $detail_permintaan = DB::table('detail_permintaan as dp')
            ->join('barang_gudang_produksi as bgp', 'dp.barang_gudang_produksi_id', '=', 'bgp.barang_gudang_produksi_id')
            ->where(['dp.permintaan_id' => $permintaan_id, 'dp.barang_gudang_produksi_id' => $barang_gudang_produksi_id])->first();

        return view('admin.pages.pengiriman.create', compact('detail_permintaan', 'user'));
    }

    public function temporary(Request $request)
    {
        $this->validate(
            $request,
            [
                'id_permintaan' => 'required',
                'id_barang' => 'required',
                'jumlah_permintaan' => 'required',
                'jumlah_dikirim' => 'required'
            ]
        );

        $temporary_pengiriman = session("temporary_pengiriman");

        $session_code = $request->id_permintaan . $request->id_barang;
        $temporary_pengiriman[$session_code] = [
            "id_permintaan" => $request->id_permintaan,
            "id_barang" => $request->id_barang,
            "jumlah_permintaan" => $request->jumlah_permintaan,
            "jumlah_pengiriman" => $request->jumlah_dikirim,
            "catatan" => (empty($request->catatan) ? "-" : $request->catatan)
        ];

        $permintaan = DB::table('permintaan')->where('permintaan_id', $request->id_permintaan)->first();

        session(["temporary_pengiriman" => $temporary_pengiriman]);

        return redirect(route('permintaan.show', ["slug" => $permintaan->slug]));
    }

    public function store($permintaan_id)
    {
        $pengiriman_id = Pengiriman::generatePengirimanId();
        $temporary_pengiriman = session("temporary_pengiriman");
        // var_dump($data);
        // die;
        $permintaan = Permintaan::where('permintaan_id', $permintaan_id)->first();
        $pengiriman = new Pengiriman;
        $pengiriman->pengiriman_id = $pengiriman_id;
        $pengiriman->slug = Str::random(16);
        $pengiriman->permintaan_id = $permintaan_id;
        $pengiriman->tanggal_pengiriman = Carbon::now();
        $pengiriman->save();
        foreach ($temporary_pengiriman as $data) {
            $detail_pengiriman = new DetailPengiriman;
            $detail_pengiriman->pengiriman_id = $pengiriman_id;
            $detail_pengiriman->barang_gudang_produksi_id = $data['id_barang'];
            $detail_pengiriman->jumlah_pengiriman = $data['jumlah_pengiriman'];
            $detail_pengiriman->catatan = $data['catatan'];
            $detail_pengiriman->save();
        }
        $permintaan->status_permintaan = 'Dikirim';
        $permintaan->save();
        $message = "Pengiriman berhasil disimpan";
        $response = "success";
        session()->forget("temporary_pengiriman");
        return redirect(route('permintaan'))->with($response, $message);
    }

    public function show($pengiriman_id)
    {
        $user = $this->userAuth();
        $detail = DB::table('detail_pengiriman as dpr')
            ->join('pengiriman as pr', 'dpr.pengiriman_id', '=', 'pr.pengiriman_id')
            ->join('barang_gudang_produksi as bgp', 'bgp.barang_gudang_produksi_id', '=', 'dpr.barang_gudang_produksi_id')
            ->where('pr.pengiriman_id', $pengiriman_id)
            ->get();

        return view('admin.pages.pengiriman.detail', compact('user', 'detail', 'pengiriman_id'));
    }

    public function update($pengiriman_id)
    {
        $pengiriman = Pengiriman::where('pengiriman_id', $pengiriman_id)->first();
        $permintaan = Permintaan::where('permintaan_id', $pengiriman->permintaan_id)->first();

        $permintaan->status_permintaan = "Diterima";
        $permintaan->save();
        $pengiriman->tanggal_penerimaan = Carbon::now();
        $pengiriman->save();
        $message = "Penerimaan berhasil";
        $response = "success";

        return redirect(route('pengiriman'))->with($response, $message);
    }
}
