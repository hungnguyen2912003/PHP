<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProfileHandleRequest;
use App\Http\Requests\Admin\UpdatePasswordHandleRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        return view('admin.profile.index', compact('id'));
    }

    public function update(UpdateProfileHandleRequest $request, $id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return redirect()->back()->with('error', 'Admin not found');
        }
        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return redirect()->route('admin.profile', $id)->with('success', 'Profile updated successfully');
    }

    public function updatePassword(UpdatePasswordHandleRequest $request, $id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return redirect()->back()->with('error', 'Admin not found');
        }
        if (!Hash::check($request->current_password, $admin->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect');
        }
        $admin->update([
            'password' => Hash::make($request->new_password),
        ]);
        return redirect()->back()->with('success', 'Password updated successfully, please login with your new password');
    }
}
