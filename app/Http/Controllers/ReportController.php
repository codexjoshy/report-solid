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
    public function commissionReport(Request $request)
    {
        // dd( );
        $data = (new CommissionReport)->orders();
        if ($request->search) {
            $data->filterBy(['first_name','last_name', 'id'], $request->search);
        }
        if ($request->from || $request->to) {
            $data->filterByDate($request->from, $request->to);
        }
        $reportData = $data->generate();
        // dd($reportData->take(5));
        $CommissionService = (new CommissionService);
        $CustomerCategoryEnum = UserCategoryEnum::CUSTOMER;
        $DistributorCategoryEnum = UserCategoryEnum::DISTRIBUTOR;
        return view('commission', compact('reportData', 'request', 'CommissionService', 'CustomerCategoryEnum','DistributorCategoryEnum'));
    }
    public function distributorReport(Request $request)
    {
        $reportData = (new DistributorsReport)->orders()->generate();
        return view('distributor', compact('reportData'));
    }

    public function commissionReportRefactor(Request $request, CommissionReport $report)
    {
        $report = $report->query();
        if($request->search) $report->filterBy(['first_name','last_name', 'id'], $request->search);
        if($request->from || $request->to) $report->filterByDate($request->from, $request->to);

        $reportData = $report->generate();
        $CommissionService = (new CommissionService);
        $CustomerCategoryEnum = UserCategoryEnum::CUSTOMER;
        $DistributorCategoryEnum = UserCategoryEnum::DISTRIBUTOR;
        return view('commission', compact('reportData', 'request', 'CommissionService', 'CustomerCategoryEnum','DistributorCategoryEnum'));
    }

    public function distributorReportRefactor(Request $request, DistributorsReport $report)
    {
      $reportData = $report->query()->generate();
      return view('distributor', compact('reportData', 'request'));
    }
}
