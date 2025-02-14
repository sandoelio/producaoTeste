<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Se não houver usuário na sessão, redirecione para o login
        if (!session()->has('usuario_id')) {
            return redirect()->route('form.entrar')->with('error', 'Acesso não autorizado.');
        }

        // Busca o usuário a partir do ID armazenado na sessão
        $user = User::find(session('usuario_id'));

        // Se não existir ou se não for admin, aborta
        if (!$user || !$user->is_admin) {
            abort(403, 'Acesso negado.');
        }

        return $next($request);
    }
}
