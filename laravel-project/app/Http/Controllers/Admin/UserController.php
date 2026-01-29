<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\Admin\StoreUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use App\Mail\ActivationMail;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function store()
    {
        $roles = Role::where('name', '!=', 'User')->get();
        return view('admin.users.store', compact('roles'));
    }

    public function storePost(StoreUserRequest $request)
    {
        $validated = $request->validated();

        // Generate username
        $baseUsername = Str::slug($validated['fullname'], '');
        $username = $baseUsername . '1';
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $counter++;
            $username = $baseUsername . $counter;
        }

        //Create activation token
        $activation_token = Str::random(64);        

        $user = User::create([
            'fullname' => $validated['fullname'],
            'email' => $validated['email'],
            'username' => $username,
            'password' => Hash::make('123456'),
            'role_id' => $validated['role_id'],
            'status' => 'pending',
            'activation_token' => $activation_token,
            'activation_token_sent_at' => Carbon::now(),
        ]);

        //Send activation email
        Mail::to($user->email)->locale(App::getLocale())->send(new ActivationMail($activation_token, $user, Carbon::now()->addMinutes(30)));

        //Success message
        flash()->success(__('messages.user_created_success'), [], __('messages.success'));
        return redirect()->route('user.index');
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
