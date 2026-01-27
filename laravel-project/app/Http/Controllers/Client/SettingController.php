<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\UpdateAccountRequest;
use App\Http\Requests\Client\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function account()
    {
        $user = Auth::user();
        return view('client.pages.setting.account-setting', compact('user'));
    }

    public function updateAccount(UpdateAccountRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        $user->update($data);
        flash()->success('Profile updated successfully.');
        return redirect()->back();
    }

    public function changePassword()
    {
        return view('client.pages.setting.change-password');
    }

    public function changePasswordUpdate(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            flash()->error('Your old password does not match.');
            return redirect()->back();
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        flash()->success('Password changed successfully.');
        return redirect()->back();
    }
}
