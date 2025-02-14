<?php

namespace App\Services;

use App\Repositories\ReportRepository;

class ReportService
{
    protected $reportRepository;

    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    /**
     * Gera os dados do relatório para os usuários (não administradores).
     *
     * @return array
     */
    public function generateReportData()
    {
        $users = $this->reportRepository->getUsersForReport();
        
        // Ordena os usuários em ordem decrescente de pontos para definir o ranking.
        $reportData = [];
        $ranking = 1;
        foreach ($users as $user) {
            
            // Carrega as respostas do usuário junto com a pergunta correspondente
            $answers = $user->answers()->with('question')->get();

            // Carrega as punições do usuário
            $penalties = $user->penalties()->get();

            $reportData[] = [
                'ranking'   => $ranking,
                'name'      => $user->name,
                'points'    => $user->points,
                'answers'   => $answers,
                'penalties' => $penalties,
            ];
            $ranking++;
        }
        return $reportData;
    }
}
