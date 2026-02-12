<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Mail\Admin\ForgotPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Forgot Password
    |--------------------------------------------------------------------------
    */
    public function showForgotPasswordForm()
    {
        return view('admin.pages.auth.forgot-password');
    }

    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        // Check role
        $user = User::where('email', $request->email)
            ->first();

        if (!$user) {
            flash()->error(__('message.forgot_password.email_not_found'), [], __('notification.error'));
            return redirect()->back()->withInput();
        }

        $roleName = strtolower($user->role);
        if (!in_array($roleName, ['admin', 'staff'], true)) {
            flash()->error(__('message.forgot_password.email_not_admin_or_staff'), [], __('notification.error'));
            return redirect()->back()->withInput();
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => Hash::make($token),
                'created_at' => Carbon::now(),
            ]
        );

        $expiresAt = Carbon::now()->addMinutes(60);


        Mail::to($user->email)
            ->locale(App::getLocale())
            ->send(new ForgotPasswordMail($token, $user->email, $user, $expiresAt));


        flash()->success(__('message.forgot_password.status.success'), [], __('notification.success'));
        return redirect()->route('admin.login');
    }
}
