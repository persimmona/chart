<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstallationStatistic extends Model
{
    static function getQualifiedLeadsByYear($year)
    {
        return InstallationStatistic::selectRaw("MONTH(created_at) as month, COUNT(DISTINCT(domain)) as count")
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('count','month')
            ->all();
    }

    static function getCancelledCustomersByYear($year)
    {
        return InstallationStatistic::selectRaw("MONTH(deleted_at) as month, COUNT(DISTINCT(domain)) as count")
            ->whereYear('deleted_at', $year)
            ->groupBy('month')
            ->pluck('count','month')
            ->all();
    }
}
