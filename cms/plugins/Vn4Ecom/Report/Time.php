<?php
namespace Vn4Ecom\Report;

class Time{
    
    const TODAY = 'today';
    const LAST_7_DAYS = 'last7Days';
    const LAST_30_DAYS = 'last30Days';
    const LAST_3_MONTHS = 'last3Months';
    const LAST_6_MONTHS = 'last6Months';
    const LAST_1_YEAR = 'last1Year';
    const LAST_2_YEARS = 'last2Years';
    const LAST_3_YEARS = 'last3Years';
    
    public static function all(){
        return [
            'today'=>'Today',
            'last7Days'=>'Last 7 days',
            'last30Days'=>'Last 30 days',
            'last3Months'=>'Last 3 months',
            'last6Months'=>'Last 6 months',
            'last1Year'=>'Last 1 year',
            'last2Years'=>'Last 2 years',
            'last3Years'=>'Last 3 years',
        ];
    }

    public static function today(){
        return [
            date('Y-m-d'),
            date('Y-m-d'),
        ];
    }

    public static function last7Days(){
        return [
            \Carbon\Carbon::now()->subDays(7),
            \Carbon\Carbon::now(),
        ];
    }

    public static function last30Days(){
        return [
            \Carbon\Carbon::now()->subDays(30),
            \Carbon\Carbon::now(),
        ];
    }

    public static function last3Months(){
        return [
            \Carbon\Carbon::now()->subMonths(3),
            \Carbon\Carbon::now(),
        ];
    }

    public static function last6Months(){
        return [
            \Carbon\Carbon::now()->subMonths(6),
            \Carbon\Carbon::now(),
        ];
    }

    public static function last1Year(){
        return [
            \Carbon\Carbon::now()->subYears(1),
            \Carbon\Carbon::now(),
        ];
    }

    public static function last2Years(){
        return [
            \Carbon\Carbon::now()->subYears(2),
            \Carbon\Carbon::now(),
        ];
    }

    public static function last3Years(){
        return [
            \Carbon\Carbon::now()->subYears(3),
            \Carbon\Carbon::now(),
        ];
    }
}