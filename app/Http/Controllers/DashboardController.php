<?php

// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        return Inertia::render('Dashboard', [
            'users' => $users,
        ]);
    }
}
