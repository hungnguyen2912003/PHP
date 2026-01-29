<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
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
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::where('name', '!=', 'User')->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }



    public function editPost(UpdateUserRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validated();

        $user->fullname = $validated['fullname'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->address = $validated['address'];
        $user->gender = $validated['gender'];
        $user->date_of_birth = $validated['date_of_birth'];
        $user->role_id = $validated['role_id'];
        $user->status = $validated['status'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        flash()->success(__('messages.profile_updated_success'), [], __('messages.success'));
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        flash()->success(__('messages.user_deleted_success'), [], __('messages.success'));
        return redirect()->back();
    }

    public function resendActivation($id)
    {
        $user = User::find($id);

        if ($user && $user->status == 'pending') {
            // Regeneration activation token
            $activation_token = Str::random(64);
            $user->activation_token = $activation_token;
            $user->activation_token_sent_at = Carbon::now();
            $user->save();

            // Send activation email
            Mail::to($user->email)->locale(App::getLocale())->send(new ActivationMail($activation_token, $user, Carbon::now()->addMinutes(30)));

            flash()->success(__('messages.resend_activation_success'), [], __('messages.success'));
        } else {
            flash()->error(__('messages.resend_activation_failed'), [], __('messages.error'));
        }

        return redirect()->back();
    }
}
