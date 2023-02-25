<?php
namespace App\Services;

use App\Interfaces\ReportInterface;

class ReportService
{
    protected $sql;
    public function query(ReportInterface $report)
    {
        $this->sql = $report->query();
    }

    public function generate(ReportInterface $report)
    {
       $report->generate($this->sql);
    }
}


?>
