<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('client.pages.profile', compact('user'));
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar_url_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

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

            flash()->success(__('messages.avatar_updated_success'), [], __('messages.success'));
        }

        return redirect()->back();
    }
}
