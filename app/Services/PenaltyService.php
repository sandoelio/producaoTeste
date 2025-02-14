<?php

namespace App\Services;

use App\Models\User;

class PenaltyService
{
    public function applyTimePenalty($userId, $questionId)
    {
        $user = User::find($userId);

        if ($user) {
            $user->points -= 6; // Penalidade de -6 pontos
            $user->save();
        }
    }
}
