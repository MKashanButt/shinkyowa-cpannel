<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Managers;
use App\Models\Roles;
use App\Models\TextPassword;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        if (Auth::user()->role == 'admin') {
            $roles = ['manager', 'agent', 'doc_uploader', 'stock_uploader', 'customer'];
        } elseif (Auth::user()->role == 'manager') {
            $roles = ['customer'];
        }
        $managers = User::where('role', 'manager')->pluck('name');
        return view('auth.register', [
            "roles" => $roles,
            "managers" => $managers,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'roles' => ['string'],
                'manager' => ['string', 'nullable']
            ]);

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            if (!$request->role) {
                $user->role = "agent";
            } else {
                $user->role = $request->role;
            }

            if ($request->manager) {
                $user->manager = $request->manager;
            }

            $user->save();

            TextPassword::create([
                'email' => $request->email,
                'password' => $request->password,
            ]);

            if ($request->role == 'manager') {
                $managers = Managers::create([
                    'manager' => $request->name
                ]);
                $managers->save();
            }
            event(new Registered($user));

            return redirect(route('dashboard', absolute: false));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
