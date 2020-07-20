<?php

namespace App\Http\Controllers;

use App\Services\ChartService;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    protected $chartService;

    public function __construct(ChartService $chartService)
    {
        $this->chartService = $chartService;
    }

    function index()
    {
        $metrics = $this->chartService->calculateMetrics();
        return view('chart', $metrics);
    }
}
