<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\settings\UpdateAccountRequest;
use App\Http\Requests\Client\settings\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Update Account Settings
    |--------------------------------------------------------------------------
    */
    public function account()
    {
        $user = Auth::guard("web")->user();
        return view('client.pages.settings.account', compact('user'));
    }

    public function updateAccount(UpdateAccountRequest $request)
    {
        $user = Auth::guard("web")->user();
        $data = $request->validated();
        $user->update($data);
        flash()->success(__('message.account.status.success'), [], __('notification.success'));
        return redirect()->back();
    }
    /*
    |--------------------------------------------------------------------------
    | Change Password
    |--------------------------------------------------------------------------
    */
    public function changePassword()
    {
        return view('client.pages.settings.change-password');
    }

    public function changePasswordUpdate(ChangePasswordRequest $request)
    {
        $user = Auth::guard("web")->user();

        if (!Hash::check($request->current_password, $user->password)) {
            flash()->error(__('message.change_password.current_password_mismatch'), [], __('notification.error'));
            return redirect()->back();
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        flash()->success(__('message.change_password.status.success'), [], __('notification.success'));
        return redirect()->back();
    }
}
