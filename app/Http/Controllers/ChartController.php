<?php

namespace App\Http\Controllers;

use App\ChargeStatistic;
use App\InstallationStatistic;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    function index()
    {
        $year = date('Y');
        $month = date('m');

        $qualifiedLeads = InstallationStatistic::getQualifiedLeadsByYear($year);
        $newCustomers =ChargeStatistic::getNewCustomersByYear($year);
        $activeCustomers = ChargeStatistic::getActiveCustomersByYear($year);
        $cancelledCustomers = InstallationStatistic::getCancelledCustomersByYear($year);

        for ($i = 1; $i <= $month; $i++) {
            $dateObj   = \DateTime::createFromFormat('!m', $i);
            $monthName = $dateObj->format('M');
            $labels[] = $monthName;
            if (isset($qualifiedLeads[$i+1])&&isset($qualifiedLeads[$i]))
                $lvr[] = intval((($qualifiedLeads[$i+1] - $qualifiedLeads[$i])/$qualifiedLeads[$i])*100);
            else
                $lvr[] = 0;
            if (isset($newCustomers[$i])&&isset($qualifiedLeads[$i]))
                $lcr[] = intval(($newCustomers[$i] / $qualifiedLeads[$i])*100);
            else
                $lcr[] = 0;
            if (isset($cancelledCustomers[$i])&&isset($activeCustomers[$i]))
                $churnRate[] = intval(($cancelledCustomers[$i] / $activeCustomers[$i])*100);
            else
                $churnRate[] = 0;
        }

        return view('chart', compact('lvr', 'lcr', 'churnRate', 'labels'));
    }
}
