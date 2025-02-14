<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function createUser($email, $name)
    {
        return User::create([
            'email' => $email,
            'name' => $name
        ]);
    }

    public function findById($id)
    {
        return User::find($id);
    }

    /**
     * Retorna os usuários (não administradores) ordenados pela pontuação,
     * limitado ao valor informado (padrão: 10).
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRanking(int $limit = 10)
    {
        return User::where('is_admin', false)
                   ->orderByDesc('points')
                   ->limit($limit)
                   ->get();
    }
}
