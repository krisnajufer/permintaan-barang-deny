<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Gudang;
use App\Models\Admin\GudangProduksi;
use App\Models\Auth\UserAuth;
use Illuminate\Support\Str;

class GudangController extends Controller
{
    public function userRole()
    {
        $user_role = Auth::guard('user')->user()->role;

        return $user_role;
    }

    public function validatorHelper($request)
    {
        $validator = Validator::make($request, [
            'nama' => 'required',
            'role' => 'required',
            'alamat' => 'required',
            'password' => 'required',
        ]);

        return $validator;
    }

    public function index()
    {
        $user_role = $this->userRole();
        if ($user_role == 'nonproduksi') {
            $gudangs = DB::table('gudang')
                ->join('users as u', 'gudang.user_id', '=', 'u.user_id')
                ->select('gudang.gudang_id', 'u.nama', 'gudang.slug as slug_gudang', 'u.slug as slug_user', 'gudang.alamat_gudang as alamat', 'u.username', 'u.role')
                ->where('u.role', '=', 'nonproduksi')
                ->get();
        } elseif ($user_role == 'produksi') {
            $gudangs = null;
        }

        return view('admin.pages.gudang.index', compact('gudangs', 'user_role'));
    }

    public function create()
    {
        $user_role = $this->userRole();
        if ($user_role == 'produksi') {
            return view('admin.pages.gudang.create');
        } else {
            return view('admin.pages.NotFound');
        }
    }

    public function Store(Request $request)
    {
        $validator = $this->validatorHelper($request->all());
        if ($validator->fails()) {
            $message = "Tidak boleh ada field yang kosong!!.";
            $response = "warning";
            return redirect(route('gudang.create'))->with($response, $message);
        } else {
            $nama = $request->nama;
            $role = $request->role;
            $alamat = $request->alamat;
            $password = bcrypt($request->password);
            $check_name = DB::table('users')->where('nama', $nama)->first();
            if (empty($check_name)) {
                if ($role == 'produksi') {
                    $users = new UserAuth;
                    $user_id = UserAuth::generateUserId();
                    $slug_user = Str::random(16);
                    $username = strtolower(str_replace(" ", "", $nama));
                    $users->user_id = $user_id;
                    $users->slug = $slug_user;
                    $users->nama = $nama;
                    $users->role = $role;
                    $users->username = $username;
                    $users->password = $password;
                    $users->save();

                    $gudang = new GudangProduksi;
                    $gudang_id = GudangProduksi::generateGudangProduksiId();
                    $slug_gudang = Str::random(16);
                    $gudang->gudang_produksi_id = $gudang_id;
                    $gudang->slug = $slug_gudang;
                    $gudang->user_id = $user_id;
                    $gudang->alamat_gudang_produksi = $alamat;
                    $gudang->save();

                    $message = "Data berhasil ditambahkan.";
                    $response = "success";
                } else {
                    $users = new UserAuth;
                    $user_id = UserAuth::generateUserId();
                    $slug_user = Str::random(16);
                    $username = strtolower(str_replace(" ", "", $nama));
                    $users->user_id = $user_id;
                    $users->slug = $slug_user;
                    $users->nama = $nama;
                    $users->role = $role;
                    $users->username = $username;
                    $users->password = $password;
                    $users->save();

                    $gudang = new Gudang;
                    $gudang_id = Gudang::generateGudangId();
                    $slug_gudang = Str::random(16);
                    $gudang->gudang_id = $gudang_id;
                    $gudang->slug = $slug_gudang;
                    $gudang->user_id = $user_id;
                    $gudang->alamat_gudang = $alamat;
                    $gudang->save();

                    $message = "Data berhasil ditambahkan.";
                    $response = "success";
                }
            } else {
                $message = "Gudang dengan nama tersebut sudah ada!!.";
                $response = "warning";
                return redirect(route('gudang.create'))->with($response, $message);
            }
        }

        return redirect(route('gudang'))->with($response, $message);
    }

    public function getGudang(Request $request)
    {
        $role = $request->role;
        if ($role == 'produksi') {
            $gudangs = DB::table('gudang_produksi')
                ->join('users as u', 'gudang_produksi.user_id', '=', 'u.user_id')
                ->select('gudang_produksi.gudang_produksi_id as gudang_id', 'u.nama', 'gudang_produksi.slug as slug_gudang', 'u.slug as slug_user', 'gudang_produksi.alamat_gudang_produksi as alamat', 'u.username', 'u.role')
                ->where('u.role', '=', 'produksi')
                ->get();

            return response()->json(array(
                'gudangs' => $gudangs,
            ), 200);
        } else {
            $gudangs = DB::table('gudang')
                ->join('users as u', 'gudang.user_id', '=', 'u.user_id')
                ->select('gudang.gudang_id as gudang_id', 'u.nama', 'gudang.slug as slug_gudang', 'u.slug as slug_user', 'gudang.alamat_gudang as alamat', 'u.username', 'u.role')
                ->where('u.role', '=', 'nonproduksi')
                ->get();

            return response()->json(array(
                'gudangs' => $gudangs,
            ), 200);
        }
    }

    public function edit($slug, $role)
    {
        $user_role = $this->userRole();
        if ($user_role == 'produksi') {
            if ($role == 'produksi') {
                $gudangs = DB::table('gudang_produksi')
                    ->join('users as u', 'gudang_produksi.user_id', '=', 'u.user_id')
                    ->select('gudang_produksi.gudang_produksi_id as gudang_id', 'u.nama', 'gudang_produksi.slug as slug_gudang', 'u.slug as slug_user', 'gudang_produksi.alamat_gudang_produksi as alamat', 'u.username', 'u.role', 'u.password')
                    ->where(['u.role' => 'produksi', 'gudang_produksi.slug' => $slug])
                    ->first();
            } else {
                $gudangs = DB::table('gudang')
                    ->join('users as u', 'gudang.user_id', '=', 'u.user_id')
                    ->select('gudang.gudang_id as gudang_id', 'u.nama', 'gudang.slug as slug_gudang', 'u.slug as slug_user', 'gudang.alamat_gudang as alamat', 'u.username', 'u.role', 'u.password')
                    ->where(['u.role' => 'nonproduksi', 'gudang.slug' => $slug])
                    ->first();
            }
            return view('admin.pages.gudang.edit', compact('gudangs'));
        } else {
            return view('admin.pages.NotFound');
        }
    }

    public function update(Request $request, $slug, $role)
    {
        $validator = $this->validatorHelper($request->all());
        if ($validator->fails()) {
            $message = "Tidak boleh ada field yang kosong!!.";
            $response = "warning";
            return redirect('/gudang/edit/' . $slug . '/' . $role)->with($response, $message);
        } else {
            if ($role == 'produksi' && $request->get('role') == 'produksi') {
                $gudang = GudangProduksi::where('slug', $slug)->first();
                $users = UserAuth::where('user_id', $gudang->user_id)->first();

                $check_name = DB::table('users')
                    ->where('nama', $request->get('nama'))
                    ->where('nama', '<>', $users->nama)
                    ->count();

                if ($check_name > 0) {
                    $message = "Gudang dengan nama tersebut sudah ada!!.";
                    $response = "warning";
                    return redirect('/gudang/edit/' . $slug . '/' . $role)->with($response, $message);
                } else {
                    $username = strtolower(str_replace(" ", "", $request->get('nama')));
                    $users->nama = $request->get('nama');
                    $users->username = $username;
                    if ($request->get('password') != $users->password) {
                        $users->password = bcrypt($request->get('password'));
                    }
                    $users->save();

                    $gudang->alamat_gudang_produksi = $request->get('alamat');
                    $gudang->save();
                    $message = "Data berhasil diubah.";
                    $response = "success";
                }
            } elseif ($role == 'produksi' && $request->get('role') == 'nonproduksi') {
                $gudang = GudangProduksi::where('slug', $slug)->first();
                $users = UserAuth::where('user_id', $gudang->user_id)->first();

                $check_name = DB::table('users')
                    ->where('nama', $request->get('nama'))
                    ->where('nama', '<>', $users->nama)
                    ->count();

                if ($check_name > 0) {
                    $message = "Gudang dengan nama tersebut sudah ada!!.";
                    $response = "warning";
                    return redirect('/gudang/edit/' . $slug . '/' . $role)->with($response, $message);
                } else {
                    $username = strtolower(str_replace(" ", "", $request->get('nama')));
                    $users->nama = $request->get('nama');
                    $users->username = $username;
                    $users->role = 'nonproduksi';
                    if ($request->get('password') != $users->password) {
                        $users->password = bcrypt($request->get('password'));
                    }
                    $users->save();
                    $gudang->delete();

                    $gudang = new Gudang;
                    $gudang->gudang_id = Gudang::generateGudangId();
                    $gudang->slug = Str::random(16);
                    $gudang->user_id = $users->user_id;
                    $gudang->alamat_gudang = $request->get('alamat');
                    $gudang->save();
                    $message = "Data berhasil diubah.";
                    $response = "success";
                }
            } elseif ($role == 'nonproduksi' && $request->get('role') == 'nonproduksi') {
                $gudang = Gudang::where('slug', $slug)->first();
                $users = UserAuth::where('user_id', $gudang->user_id)->first();

                $check_name = DB::table('users')
                    ->where('nama', $request->get('nama'))
                    ->where('nama', '<>', $users->nama)
                    ->count();

                if ($check_name > 0) {
                    $message = "Gudang dengan nama tersebut sudah ada!!.";
                    $response = "warning";
                    return redirect('/gudang/edit/' . $slug . '/' . $role)->with($response, $message);
                } else {
                    $username = strtolower(str_replace(" ", "", $request->get('nama')));
                    $users->nama = $request->get('nama');
                    $users->username = $username;
                    if ($request->get('password') != $users->password) {
                        $users->password = bcrypt($request->get('password'));
                    }
                    $users->save();

                    $gudang->alamat_gudang = $request->get('alamat');
                    $gudang->save();
                    $message = "Data berhasil diubah.";
                    $response = "success";
                }
            } elseif ($role == 'nonproduksi' && $request->get('role') == 'produksi') {
                $gudang = Gudang::where('slug', $slug)->first();
                $users = UserAuth::where('user_id', $gudang->user_id)->first();

                $check_name = DB::table('users')
                    ->where('nama', $request->get('nama'))
                    ->where('nama', '<>', $users->nama)
                    ->count();

                if ($check_name > 0) {
                    $message = "Gudang dengan nama tersebut sudah ada!!.";
                    $response = "warning";
                    return redirect('/gudang/edit/' . $slug . '/' . $role)->with($response, $message);
                } else {
                    $username = strtolower(str_replace(" ", "", $request->get('nama')));
                    $users->nama = $request->get('nama');
                    $users->username = $username;
                    $users->role = 'produksi';
                    if ($request->get('password') != $users->password) {
                        $users->password = bcrypt($request->get('password'));
                    }
                    $users->save();
                    $gudang->delete();

                    $gudang = new GudangProduksi;
                    $gudang->gudang_produksi_id = GudangProduksi::generateGudangProduksiId();
                    $gudang->slug = Str::random(16);
                    $gudang->user_id = $users->user_id;
                    $gudang->alamat_gudang_produksi = $request->get('alamat');
                    $gudang->save();
                    $message = "Data berhasil diubah.";
                    $response = "success";
                }
            }
            return redirect(route('gudang'))->with($response, $message);
        }
    }

    public function destroy($slug_gudang, $slug_user, $role)
    {
        $gudang = ($role == 'produksi') ? GudangProduksi::where('slug', $slug_gudang)->first() : Gudang::where('slug', $slug_gudang)->first();
        UserAuth::where('slug', $slug_user)->delete();
        $gudang->delete();

        $message = "Data berhasil dihapus.";
        $response = "success";
        return redirect(route('gudang'))->with($response, $message);
    }
}
