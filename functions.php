<?php

function curl(string $url): string {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function fround(?float $num): string {
    if (is_null($num)) {
        return "-";
    } else {
        return str_replace(".", ",", number_format($num, 2));
    }
}

function color(?float $num): string {
    if (is_null($num)) {
        return "";
    }
    if ($num > 100) {
        return "danger-extreme";
    } elseif ($num > 50) {
        return "danger-high";
    } elseif ($num > 35) {
        return "danger-medium";
    } else {
        return "danger-low";
    }
}
