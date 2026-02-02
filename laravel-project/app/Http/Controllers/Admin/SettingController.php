<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\settings\UpdateAccountRequest;
use App\Http\Requests\Admin\settings\ChangePasswordRequest;
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
        $user = Auth::guard("admin")->user();
        return view('admin.pages.setting.account', compact('user'));
    }

    public function updateAccount(UpdateAccountRequest $request)
    {
        $user = Auth::guard("admin")->user();
        $data = $request->validated();
        $user->update($data);
        flash()->success(__('messages/settings.account.status.success'), [], __('common.success'));
        return redirect()->back();
    }
    /*
    |--------------------------------------------------------------------------
    | Change Password
    |--------------------------------------------------------------------------
    */
    public function changePassword()
    {
        return view('admin.pages.setting.change-password');
    }

    public function changePasswordUpdate(ChangePasswordRequest $request)
    {
        $user = Auth::guard("admin")->user();

        if (!Hash::check($request->current_password, $user->password)) {
            flash()->error(__('messages/settings.change_password.current_password_mismatch'), [], __('common.error'));
            return redirect()->back();
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        flash()->success(__('messages/settings.change_password.status.success'), [], __('common.success'));
        return redirect()->back();
    }
}
