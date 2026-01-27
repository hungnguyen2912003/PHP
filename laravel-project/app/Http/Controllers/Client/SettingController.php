<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\UpdateAccountRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            $data['avatar_url'] = 'storage/' . $path;
        }

        $user->update($data);

        flash()->success('Account settings updated successfully.');
        return redirect()->back();
    }
}
