<?php

namespace App\Repositories;

use App\Models\User;

class ReportRepository
{
    /**
     * Retorna todos os usuários não administradores ordenados pela pontuação (decrescente).
     *
     * @param int $limit (opcional, se você quiser limitar)
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsersForReport($limit = null)
    {
        $query = User::where('is_admin', false)
                     ->orderByDesc('points');
        
        if ($limit) {
            $query->limit($limit);
        }
        
        return $query->get();
    }
}
