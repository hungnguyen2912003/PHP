<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProfileHandleRequest;
use App\Http\Requests\Admin\UpdatePasswordHandleRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\ImageUploadTrait;

class ProfileController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = auth()->guard('admin')->id();
        return view('admin.profile.index', compact('id'));
    }

    public function update(UpdateProfileHandleRequest $request, $id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            toast(__('admin.toast.admin_not_found'), 'error')->width('400px');
            return redirect()->back();
        }
        $image = $this->uploadImage($request, 'image', $admin->image);
        if ($image) {
            $admin->image = $image;
        }
        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        toast(__('admin.toast.profile_updated_successfully'), 'success')->width('400px');

        return redirect()->route('admin.profile.index');
    }

    public function updatePassword(UpdatePasswordHandleRequest $request, $id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            toast(__('admin.toast.admin_not_found'), 'error')->width('400px');
            return redirect()->back();
        }
        $admin->update([
            'password' => Hash::make($request->new_password),
        ]);
        toast(__('admin.toast.password_updated_successfully'), 'success')->width('400px');
        return redirect()->back();
    }
}
