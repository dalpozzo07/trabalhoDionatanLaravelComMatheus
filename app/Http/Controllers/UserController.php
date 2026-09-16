<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $dados = $request->validate([
            'role' => 'required|in:admin,gerente,cliente',
        ]);

        $user->update([
            'role' => $dados['role'],
        ]);

        return redirect()
            ->route('users.index')
            ->with('sucesso', 'Cargo do usuário atualizado com sucesso!');
    }
}
