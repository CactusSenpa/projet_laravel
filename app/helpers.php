<?php

if (! function_exists('tnd')) {
    function tnd(float|int|string|null $amount): string
    {
        return number_format((float) $amount, 2, ',', ' ').' TND';
    }
}

if (! function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return \App\Models\Setting::getValue($key, $default);
    }
}

if (! function_exists('whatsapp_url')) {
    function whatsapp_url(?string $message = null): string
    {
        $number = preg_replace('/\D+/', '', (string) setting('whatsapp_number', '21620000000'));
        $url = 'https://wa.me/'.$number;

        if ($message) {
            $url .= '?text='.rawurlencode($message);
        }

        return $url;
    }
}

if (! function_exists('reservation_nights')) {
    function reservation_days(\Carbon\CarbonInterface $start, \Carbon\CarbonInterface $end): int
    {
        return max(1, $start->diffInDays($end) + 1);
    }
}
