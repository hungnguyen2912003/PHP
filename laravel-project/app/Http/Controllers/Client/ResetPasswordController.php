<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Reset Password
    |--------------------------------------------------------------------------
    */
    public function showResetPasswordForm(Request $request, $token)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            flash()->error(__('message.reset_password.user_not_found'), [], __('notification.error'));
            return redirect()->route('client.login');
        }

        return view('client.pages.auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
            'username' => $user?->username ?? '',
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request, $token)
    {
        $reset = \DB::table('password_reset_tokens')->where('email', $request->email)->first();

        // Check if token exists
        if (!$reset) {
            flash()->error(__('message.reset_password.token_invalid'), [], __('notification.error'));
            return redirect()->route('client.login');
        }

        // Check if token is expired (60 mins)
        if (Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            flash()->error(__('message.reset_password.token_expired'), [], __('notification.error'));
            return redirect()->route('client.login');
        }

        // Check if token is valid
        if (!Hash::check($token, $reset->token)) {
            flash()->error(__('message.reset_password.token_invalid'), [], __('notification.error'));
            return redirect()->route('client.login');
        }

        // Check user existence
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            flash()->error(__('message.reset_password.user_not_found'), [], __('notification.error'));
            return redirect()->route('client.login');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        //Delete password reset token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        flash()->success(__('message.reset_password.status.success'), [], __('notification.success'));
        return redirect()->route('client.login');
    }
}
