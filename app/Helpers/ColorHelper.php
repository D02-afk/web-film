<?php

if (!function_exists('darken_color')) {
    function darken_color($hex, $percent = 20) {
        $hex = ltrim($hex, '#');
        [$r, $g, $b] = array_map('hexdec', str_split($hex, 2));
        $r = max(0, $r - ($r * $percent / 100));
        $g = max(0, $g - ($g * $percent / 100));
        $b = max(0, $b - ($b * $percent / 100));
        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }
}