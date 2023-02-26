<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\UserCategoryEnum;
use App\Report\CommissionReport;
use App\Report\DistributorsReport;
use App\Services\CommissionService;
class ReportController extends Controller
{
    public function commissionReport(Request $request, CommissionReport $report)
    {
        $report = $report->query();
        if($request->search) $report->filterBy(['first_name','last_name', 'id'], $request->search);
        if($request->from || $request->to) $report->filterByDate($request->from, $request->to);

        $reportData = $report->generate();
        $CommissionService = (new CommissionService);
        $CustomerCategoryEnum = UserCategoryEnum::CUSTOMER;
        $DistributorCategoryEnum = UserCategoryEnum::DISTRIBUTOR;
        return view('commission', compact('reportData', 'request', 'CommissionService', 'OrderService', 'CustomerCategoryEnum','DistributorCategoryEnum'));
    }

    public function distributorReport(Request $request, DistributorsReport $report)
    {
      $reportData = $report->query()->generate();
      return view('distributor', compact('reportData', 'request'));
    }
}
