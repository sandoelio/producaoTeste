<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\UserService;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function showLoginForm()
    {
        return view('auth.entrar');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'name'  => 'required'
        ]);

        $user = $this->userService->authenticateUser($validated['email'], $validated['name']);

        // Redireciona para o dashboard
        return redirect()->route('game.dashboard');
    }

    public function dashboard()
    {
        if (!Session::has('usuario_id')) {
            return redirect()->route('form.entrar');
        }

        $user = $this->userService->getUserById(Session::get('usuario_id'));

        return view('game.dashboard', compact('user'));
    }

    public function logout()
    {
        Session::forget('usuario_id');
        Session::forget('usuario_email');

        return redirect()->route('form.entrar');
    }
}
