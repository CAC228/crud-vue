<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birthdate' => 'nullable|date',
            'phonenumber' => 'nullable|string|max:255',
            'email' => 'required|string|max:255',
            'login' => 'nullable|string|max:255',
            'password' => 'required|string|max:255',
            'photo' => 'nullable|image'
        ]);

        User::create($request->all());

        return back()->with('success', 'Пользователь успешно создан.');
    }

    public function update(Request $request, User $User)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birthdate' => 'nullable|date',
            'phonenumber' => 'nullable|string|max:255',
            'email' => 'required|string|max:255',
            'login' => 'nullable|string|max:255',
            'password' => 'required|string|max:255',
            'photo' => 'nullable|image'
        ]);

        $User->update($request->all());

        return back()->with('success', 'Пользователь успешно обновлен.');
    }

    public function destroy(User $User)
    {
        $User->delete();

        return back()->with('success', 'Пользователь успешно удален.');
    }
}
