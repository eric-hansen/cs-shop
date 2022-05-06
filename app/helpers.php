<?php

if (!function_exists('format_currency')) {
    function format_currency($value, $centsPerDollar = 100, $precision = 2, $currencyIndicator = '$')
    {
        return $currencyIndicator . number_format($value / $centsPerDollar, $precision);
    }
}