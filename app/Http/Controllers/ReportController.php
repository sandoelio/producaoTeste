<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReportService;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index()
    {
        // Gera os dados do relatório
        $reportData = $this->reportService->generateReportData();
        return view('admin.report', compact('reportData'));
    }
}
