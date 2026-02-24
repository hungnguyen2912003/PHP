<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Admin\users\StoreUserRequest;
use App\Http\Requests\Admin\users\UpdateUserRequest;
use App\DataTables\UsersDataTable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Mail\Admin\ActivationMail;
class UserController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('admin.pages.users.index');
    }

    public function create()
    {
        return view('admin.pages.users.create');
    }

    public function store(StoreUserRequest $request)
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
        $plainToken = Str::random(64);
        $hashedToken = hash('sha256', $plainToken);

        try {
            DB::transaction(function () use ($validated, $username, $hashedToken, $plainToken) {
                $user = User::create([
                    'fullname' => $validated['fullname'],
                    'email' => $validated['email'],
                    'username' => $username,
                    'password' => Hash::make('123456'),
                    'role' => $validated['role'],
                    'status' => User::STATUS_PENDING,
                    'activation_token' => $hashedToken,
                    'activation_token_sent_at' => Carbon::now(),
                ]);

                //Send activation email
                Mail::to($user->email)
                    ->locale(App::getLocale())
                    ->send(new ActivationMail($plainToken, $user, Carbon::now()->addMinutes(30)));
            });

            //Success message
            flash()->success(__('message.user.created'), [], __('notification.success'));
            return redirect()->route('admin.users.index');
        } catch (\Throwable $e) {
            report($e);
            flash()->error(__('message.user.resend_activation_failed'), [], __('notification.error'));
            return back();
        }
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.pages.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.pages.users.edit', compact('user'));
    }



    public function editPost(UpdateUserRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validated();

        $user->fullname = $validated['fullname'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->address = $validated['address'] ?? null;
        $user->gender = $validated['gender'] ?? null;
        $user->date_of_birth = $validated['date_of_birth'] ?? null;
        $user->role = $validated['role'];
        $user->status = $validated['status'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        flash()->success(__('message.user.updated'), [], __('notification.success'));
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        flash()->success(__('message.user.deleted'), [], __('notification.success'));
        return redirect()->back();
    }
}
