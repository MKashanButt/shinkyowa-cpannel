<?php

namespace App\Http\Controllers;

use App\Models\Managers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $users = User::where('role', '=', 'manager')
                ->where('name', '!=', Auth::user()->name)
                ->orderBy('id', 'DESC')
                ->get();
            if ($users) {
                $users = User::all();
            }
        } else {
            $users = User::where('manager', '=', Auth::user()->name)
                ->orderBy('id', 'DESC')
                ->get();
        }

        return view('pages.users.index', [
            "title" => "User Accounts",
            "stylesheet" => "users.css",
            "users" => $users
        ]);
    }

    public function team_members($manager)
    {
        $users = User::where('manager', $manager)
            ->orderBy('id', 'DESC')
            ->get();

        return view('users.index', [
            "title" => "User Accounts",
            "stylesheet" => "users.css",
            "users" => $users
        ]);
    }

    public function credentials($id)
    {
        $user = User::where('id', $id)
            ->orderBy('id', 'desc')
            ->first();

        $managers = Managers::all()->toArray();

        return view('pages.users.user-credentials', [
            "title" => "User Accounts",
            "stylesheet" => "users.css",
            "user" => $user,
            "managers" => $managers,
            "stylesheet" => "user-credentials.css",
            "name" => $user["name"]
        ]);
    }

    public function update_credentials(Request $request)
    {
        $id = $request->input('id');
        $user = User::findOrFail($id);
        $name = $request->input('name');
        $manager = $request->input('manager');
        $managerName = $request->input('managerName');
        $password = $request->input('password');

        if ($name) {
            $user->update([
                'name' => $name,
            ]);
        }

        if ($password) {
            $user->update([
                'password' => Hash::make($password)
            ]);
        }

        if (!$manager) {
            $user->update([
                'role' => 'manager'
            ]);
        } else {
            $user->update([
                'role' => 'agent'
            ]);
        }

        if ($managerName) {
            $user->update([
                'manager' => $managerName
            ]);
        }

        $user->save();

        return redirect('pages.users.index');
    }

    public function destroy($id)
    {
        User::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Account Deleted');
    }
}
