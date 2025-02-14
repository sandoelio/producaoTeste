<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;
use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticateUser($email, $name)
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            $user = $this->userRepository->createUser($email, $name);
        }

        // Salva o usuário na sessão
        Session::put('usuario_id', $user->id);
        Session::put('usuario_email', $user->email);

        return $user;
    }

    public function getUserById($id)
    {
        return $this->userRepository->findById($id);
    }

    /**
     * Retorna o ranking dos usuários (não administradores).
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
    */
    public function getRanking(int $limit = 10)
    {
        return $this->userRepository->getRanking($limit);
    }
}
