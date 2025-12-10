<?php

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return \App\Models\Setting::get($key, $default);
    }
}
if (!function_exists('adjustBrightness')) {
    function adjustBrightness($hex, $percent = -30)
    {
        $hex = ltrim($hex, '#');
        $rgb = array_map('hexdec', str_split($hex, 2));

        foreach ($rgb as &$value) {
            $value = max(0, min(255, $value + ($percent * 2.55)));
        }

        return '#' . sprintf('%02x%02x%02x', ...$rgb);
    }
}