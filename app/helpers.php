<?php
// app/helpers.php

if (!function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return \App\Models\Setting::get($key, $default);
    }
}

if (!function_exists('format_currency')) {
    function format_currency(float $amount): string
    {
        $symbol = setting('general.currency_symbol', '₹');
        return $symbol . number_format($amount, 2);
    }
}

if (!function_exists('format_date')) {
    function format_date(?string $date): string
    {
        if (!$date) return 'N/A';
        $format = setting('general.date_format', 'd/m/Y');
        return \Carbon\Carbon::parse($date)->format($format);
    }
}
