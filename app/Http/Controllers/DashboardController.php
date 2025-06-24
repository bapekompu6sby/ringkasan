<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\PelatihanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function reset_password($user_id)
    {
        return view('reset_password', ['user_id' => $user_id]);
    }
    public function update_password($id_user, Request $request)
    {
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $user = UserModel::find($id_user);
        if (Hash::check($old_password, $user->password)) {
            $user->password = Hash::make($new_password);
            $user->save();
            return redirect('/pelatihan-berlangsung')->with(['success' => 'Password berhasil diubah', 'popUp_title' => 'Success!']);
        } else {
            return redirect('/reset-password/'. $id_user)->with(['error' => 'Password lama yang Anda masukkan salah', 'popUp_title' => 'Error!']);
        }
    }

    
}