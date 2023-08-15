<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $books = auth()->user()
            ->books()
            ->orderByDesc('return_date')
            ->paginate(5);

        return \view('dashboard', compact('books'));
    }
}
