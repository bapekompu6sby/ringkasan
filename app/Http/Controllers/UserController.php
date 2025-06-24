<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function user()
    {
        $user = UserModel::orderBy('id')->get();
        return view('user.user',['users' => $user]);
    }
    public function user_tambah()
    {
        return view('user.user_tambah');
    }
    public function user_insert(Request $request): RedirectResponse
    {
        if (!$request->validate([
            'nip' => 'required',
            'nama_lengkap' => 'required',
            'role' => 'required',
            'password' => 'required',
        ])) {
            return redirect()->back()->withErrors([
                'nip',
                'nama_lengkap',
                'role',
                'password',
            ]);
        }

        $request->merge(['password' => Hash::make($request->password)]);

        // Ambil record terakhir dari tabel
        $lastRecord = userModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 2));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'JP' diikuti oleh angka yang telah diincrement
        $newId = 'US' . str_pad($number, 3, '0', STR_PAD_LEFT);

        // Tambahkan ID yang telah diincrement ke dalam request
        $request->merge(['id' => $newId]);

        // Buat record baru menggunakan metode create
        UserModel::create($request->all());

        return redirect('/kelola-pengguna')->with(['success' => 'Data pengguna berhasil ditambahkan', 'popUp_title' => 'Added!']);
    }
    public function user_edit($id)
    {
        $user = UserModel::find($id);
        return view('user.user_edit', ['user' => $user]);
    }

    public function user_update(Request $request): RedirectResponse
    {
        if (!$request->validate([
            'nip' => 'required',
            'nama_lengkap' => 'required',
        ])) {
            return redirect()->back()->withErrors([
                'nip',
                'nama_lengkap',
            ]);
        }

        $user = UserModel::find($request->id);
        $user->update($request->all());

        return redirect('/kelola-pengguna')->with(['success' => 'Data pengguna berhasil diubah', 'popUp_title' => 'Updated!']);
    }
    public function user_resetPassword($id)
    {
        return view('user.user_resetPassword', ['user_id' => $id]);
    }
    public function user_updatePassword(Request $request)
    {
                   
        if (!$request->validate([
            'password' => 'required',
        ])) {
            return redirect()->back()->withErrors([
                'password',
            ]);
        }

        $hashedPassword = Hash::make($request->password);

        // Temukan user berdasarkan ID
        $user = UserModel::find($request->id);

        $user->password = $hashedPassword;
        $user->save();

        return redirect('/kelola-pengguna')->with(['success' => 'Reset password berhasil', 'popUp_title' => 'Updated!']);
    }

    public function user_delete($id)
    {
        UserModel::find($id)->delete();

        return redirect('/kelola-pengguna')->with(['success' => 'Data pengguna berhasil dihapus', 'popUp_title' => 'Deleted!']);
    }

}