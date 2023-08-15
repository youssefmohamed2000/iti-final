<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        if (\request()->has('user_id') && \request()->get('user_id') !== null) {
            $users = User::query()
                ->where('id', '=', \request()->get('user_id'))
                ->paginate(1);
        } else {
            $users = User::query()
                ->where('is_admin', '=', false)
                ->paginate(5);
        }

        return view('users.index', compact('users'));
    }
}
