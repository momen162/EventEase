<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('id')->get(['id','name','email','role','created_at']);
        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        abort_if(auth()->id() === $user->id, 403);
        $user->delete();
        return back();
    }
}
