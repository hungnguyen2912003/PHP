<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\AvatarUploadRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $user = Auth::guard('admin')->user();
        return view('admin.pages.profile.index', compact('user'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Avatar
    |--------------------------------------------------------------------------
    */
    public function updateAvatar(AvatarUploadRequest $request)
    {
        $user = Auth::guard('admin')->user();

        if ($request->hasFile('avatar_url_file')) {
            // Delete old avatar if exists
            if ($user->avatar_url) {
                $oldPath = str_replace('storage/', '', $user->avatar_url);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            // Store new avatar in user-specific folder
            $path = $request->file('avatar_url_file')->store($user->id . '/avatars', 'public');
            $user->avatar_url = 'storage/' . $path;
            $user->save();

            flash()->success(__('messages/profile.avatar_url_file.status.success'), [], __('common.success'));
        }

        return redirect()->back();
    }
}
