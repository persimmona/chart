<?php

namespace App\Services;

use App\Models\ChargeStatistic;
use App\Models\InstallationStatistic;

class ChartService
{
    protected $chargeStatistic, $installationStatistic;

    public function __construct(
        InstallationStatistic $installationStatistic,
        ChargeStatistic $chargeStatistic
    ) {
        $this->installationStatistic = $installationStatistic;
        $this->chargeStatistic = $chargeStatistic;
    }

    public function calculateMetrics()
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
            if (isset($qualifiedLeads[$i])&&isset($qualifiedLeads[$i-1]))
                $lvr[] = intval(($qualifiedLeads[$i] - $qualifiedLeads[$i-1])/$qualifiedLeads[$i-1]*100);
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

        return compact('lvr', 'lcr', 'churnRate', 'labels');
    }
}

