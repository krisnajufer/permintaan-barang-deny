<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\BarangGudang;
use App\Models\Admin\BarangGudangProduksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    public function userAuth()
    {
        $user = Auth::guard('user')->user();

        return $user;
    }

    public function validatorHelper($request)
    {
        $user = $this->userAuth();
        if ($user->role == 'produksi') {
            $validator = Validator::make($request, [
                'nama_barang' => 'required'
            ]);
        } else {
            $validator = Validator::make($request, [
                'id_barang' => 'required',
                'quantity' => 'required'
            ]);
        }
        return $validator;
    }

    public function index()
    {
        $user = $this->userAuth();
        if ($user->role == 'nonproduksi') {
            $barangs = DB::table('barang_gudang as bg')
                ->join('barang_gudang_produksi as bgp', 'bg.barang_gudang_produksi_id', '=', 'bgp.barang_gudang_produksi_id')
                ->join('gudang as g', 'bg.gudang_id', '=', 'g.gudang_id')
                ->join('users as u', 'g.user_id', '=', 'u.user_id')
                ->select('bg.barang_gudang_id as barang_gudang_id', 'bg.slug as slug_barang', 'u.nama as nama_gudang', 'bgp.nama_barang as nama_barang', 'bg.quantity_barang_gudang as quantity')
                ->where('u.user_id', $user->user_id)
                ->get();
        } elseif ($user->role == 'produksi') {
            $barangs = NULL;
        }

        return view('admin.pages.barang.index', compact('barangs', 'user'));
    }

    public function getBarang(Request $request)
    {
        $user = $this->userAuth();
        $role = $request->role;
        if ($role == 'produksi') {
            if ($user->role == 'produksi') {
                $barangs = DB::table('barang_gudang_produksi as bgp')
                    ->leftjoin('gudang_produksi as gp', 'bgp.gudang_produksi_id', '=', 'gp.gudang_produksi_id')
                    ->leftjoin('users as u', 'gp.user_id', '=', 'u.user_id')
                    ->select('bgp.barang_gudang_produksi_id as barang_gudang_id', 'bgp.slug as slug_barang', 'u.nama as nama_gudang', 'bgp.nama_barang as nama_barang')
                    ->where('u.user_id', $user->user_id)
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
            if ($user->role == 'nonproduksi') {
                $barangs = DB::table('barang_gudang as bg')
                    ->join('barang_gudang_produksi as bgp', 'bg.barang_gudang_produksi_id', '=', 'bgp.barang_gudang_produksi_id')
                    ->join('gudang as g', 'bg.gudang_id', '=', 'g.gudang_id')
                    ->join('users as u', 'g.user_id', '=', 'u.user_id')
                    ->select('bg.barang_gudang_id as barang_gudang_id', 'bg.slug as slug_barang', 'u.nama as nama_gudang', 'bgp.nama_barang as nama_barang', 'bg.quantity_barang_gudang as quantity')
                    ->where('u.user_id', $user->user_id)
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

    public function create()
    {
        $user = $this->userAuth();
        if ($user->role == 'nonproduksi') {
            $barangs = DB::table('barang_gudang_produksi as bgp')
                ->leftjoin('barang_gudang as bg', 'bgp.barang_gudang_produksi_id', '=', 'bg.barang_gudang_produksi_id')
                ->leftjoin('gudang as g', 'bg.gudang_id', '=', 'g.gudang_id')
                ->leftjoin('users as u', 'g.user_id', '=', 'u.user_id')
                ->select('bgp.barang_gudang_produksi_id as barang_id', 'bgp.nama_barang')
                ->whereNull('bg.barang_gudang_produksi_id')
                ->orWhere('u.user_id', '<>', $user->user_id)
                ->distinct(['bgp.barang_gudang_produksi_id as barang_id', 'bgp.nama_barang'])
                ->get();
        } else {
            $barangs = NULL;
        }

        return view('admin.pages.barang.create', compact('user', 'barangs'));
    }

    public function store(Request $request)
    {
        $user = $this->userAuth();
        $validator = $this->validatorHelper($request->all());
        if ($validator->fails() || $request->id_barang == 'Pilih Barang') {
            $message = "Tidak boleh ada field yang kosong!!.";
            $response = "warning";
            return redirect(route('barang.create'))->with($response, $message);
        } else {
            if ($user->role == 'produksi') {
                $check_name = DB::table('barang_gudang_produksi')
                    ->where('nama_barang', $request->nama_barang)
                    ->first();
                if (!empty($check_name)) {
                    $message = "Nama barang tersebut sudah ada!!.";
                    $response = "warning";
                    return redirect(route('barang.create'))->with($response, $message);
                } else {
                    $gudangs = DB::table('gudang_produksi')->where('user_id', $user->user_id)->first();
                    $gudang_id = $gudangs->gudang_produksi_id;
                    $barang_id = BarangGudangProduksi::generateBarangGudangProduksiId();
                    $barang = new BarangGudangProduksi;
                    $barang->barang_gudang_produksi_id = $barang_id;
                    $barang->slug = Str::random(16);
                    $barang->gudang_produksi_id = $gudang_id;
                    $barang->nama_barang = $request->nama_barang;
                    $barang->save();
                    $message = "Data berhasil ditambahkan.";
                    $response = "success";
                }
            } else {
                $gudangs = DB::table('gudang')->where('user_id', $user->user_id)->first();
                $gudang_id = $gudangs->gudang_id;
                $barang_id = $gudang_id . $request->id_barang;
                $barang = new BarangGudang;
                $barang->barang_gudang_id = $barang_id;
                $barang->barang_gudang_produksi_id = $request->id_barang;
                $barang->slug = Str::random(16);
                $barang->gudang_id = $gudang_id;
                $barang->quantity_barang_gudang = $request->quantity;
                $barang->save();
                $message = "Data berhasil ditambahkan.";
                $response = "success";
            }
            return redirect(route('barang'))->with($response, $message);
        }
    }

    public function edit($slug)
    {
        $user = $this->userAuth();
        if ($user->role == 'produksi') {
            $data =  DB::table('barang_gudang_produksi as bgp')
                ->leftjoin('gudang_produksi as gp', 'bgp.gudang_produksi_id', '=', 'gp.gudang_produksi_id')
                ->leftjoin('users as u', 'gp.user_id', '=', 'u.user_id')
                ->select('bgp.barang_gudang_produksi_id as barang_gudang_id', 'bgp.slug as slug_barang', 'u.nama as nama_gudang', 'bgp.nama_barang as nama_barang')
                ->where('bgp.slug', $slug)
                ->first();

            return view('admin.pages.barang.edit', compact('data', 'user'));
        } else {
            $data = DB::table('barang_gudang as bg')
                ->join('barang_gudang_produksi as bgp', 'bg.barang_gudang_produksi_id', '=', 'bgp.barang_gudang_produksi_id')
                ->join('gudang as g', 'bg.gudang_id', '=', 'g.gudang_id')
                ->join('users as u', 'g.user_id', '=', 'u.user_id')
                ->select('bg.barang_gudang_id as barang_gudang_id', 'bg.slug as slug_barang', 'u.nama as nama_gudang', 'bgp.nama_barang as nama_barang', 'bg.quantity_barang_gudang as quantity')
                ->where('bg.slug', $slug)
                ->first();

            return view('admin.pages.barang.edit', compact('data', 'user'));
        }
    }

    public function update(Request $request, $slug)
    {
        $user = $this->userAuth();
        $validator = $this->validatorHelper($request->all());
        if ($validator->fails()) {
            $message = "Tidak boleh ada field yang kosong!!.";
            $response = "warning";
            return redirect('/barang/edit/' . $slug)->with($response, $message);
        } else {
            if ($user->role == 'produksi') {
                $check_name = DB::table('barang_gudang_produksi')
                    ->where('nama_barang', $request->nama_barang)
                    ->first();
                if (!empty($check_name)) {
                    $message = "Nama barang tersebut sudah ada atau Tidak Boleh Sama !!.";
                    $response = "warning";
                    return redirect('/barang/edit/' . $slug)->with($response, $message);
                } else {
                    $barang = BarangGudangProduksi::where('slug', $slug)->first();
                    $barang->nama_barang = $request->nama_barang;
                    $barang->save();
                    $message = "Data berhasil diubah.";
                    $response = "success";
                }
            } else {
                $barang = BarangGudang::where('slug', $slug)->first();
                $barang->quantity_barang_gudang = $request->quantity;
                $barang->save();
                $message = "Data berhasil diubah.";
                $response = "success";
            }
            return redirect(route('barang'))->with($response, $message);
        }
    }

    public function destroy($slug)
    {
        $user = $this->userAuth();
        if ($user->role == 'produksi') {
            $barang = BarangGudangProduksi::where('slug', $slug)->first();
            $check_barang = DB::table('barang_gudang')
                ->where('barang_gudang_produksi_id', $barang->barang_gudang_produksi_id)
                ->count();

            if ($check_barang > 0) {
                $response = "warning";
                $message = "Data barang tidak dapat dihapus karena telah ada digudang lain.";
                return redirect(route('barang'))->with($response, $message);
            }
            $barang->delete();
            $response = "success";
            $message = "Data barang berhasil dihapus.";
        } else {
            $barang = BarangGudang::where('slug', $slug)->first();
            $check_barang = DB::table('permintaan as p')
                ->join('detail_permintaan as dp', 'p.permintaan_id', '=', 'dp.permintaan_id')
                ->where(['dp.barang_gudang_produksi_id' => $barang->barang_gudang_produksi_id, 'p.user_id' => $user->user_id])
                ->count();

            if ($check_barang > 0) {
                $response = "warning";
                $message = "Data barang tidak dapat dihapus karena telah ada digudang lain.";
                return redirect(route('barang'))->with($response, $message);
            }
            $barang->delete();
            $response = "success";
            $message = "Data barang berhasil dihapus.";
        }
        return redirect(route('barang'))->with($response, $message);
    }
}
