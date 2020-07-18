<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChargeStatistic extends Model
{
    static function getNewCustomersByYear($year)
    {
        return ChargeStatistic::selectRaw('MONTH(created_at) as month, COUNT(DISTINCT(domain)) as count')
            ->where('charge', 'active')
            ->whereRaw('trial_ends_on < created_at')
            ->whereYear('created_at', $year)
            ->whereExists(function ($query) {
                $query->select('installation_statistics.domain')
                    ->from('installation_statistics')
                    ->whereRaw('installation_statistics.domain = charge_statistics.domain')
                    ->whereRaw('MONTHNAME(installation_statistics.created_at) = MONTHNAME(charge_statistics.created_at)');
            })
            ->groupBy('month')
            ->pluck('count','month')
            ->all();
    }

    static function getActiveCustomersByYear($year)
    {
        return ChargeStatistic::selectRaw('MONTH(created_at) as month, COUNT(DISTINCT(domain)) as count')
            ->where('charge', 'active')
            ->whereRaw('trial_ends_on < created_at')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('count','month')
            ->all();
    }
}
