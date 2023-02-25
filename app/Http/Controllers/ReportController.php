<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\UserCategoryEnum;
use App\Report\CommissionReport;
use App\Report\DistributorsReport;
use App\Services\CommissionService;
use App\Services\ReportService;

class ReportController extends Controller
{
    public ReportService $reportService;

    public function __construct(ReportService $reportService) {
        $this->reportService = $reportService;
    }

    public function commissionReport(Request $request)
    {
        $data = (new CommissionReport)->orders();
        if ($request->search) {
            $data->filterBy(['first_name','last_name', 'id'], $request->search);
        }
        if ($request->from || $request->to) {
            $data->filterByDate($request->from, $request->to);
        }
        $reportData = $data->generate();
        $CommissionService = (new CommissionService);
        return view('commission', compact('reportData', 'request', 'CommissionService'));
    }
    public function distributorReport(Request $request)
    {
        $reportData = (new DistributorsReport)->orders()->generate();
        // dd($reportData->take(5));

        return view('distributor', compact('reportData'));
    }

    public function report1()
    {
        $this->reportService->generate(new CommissionReport);
    }
}
