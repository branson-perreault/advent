<?php

$lines = file("./input/d3.txt", FILE_IGNORE_NEW_LINES);

$bits = array_fill(0, strlen($lines[0]), 0);
foreach ($lines as $i => $line) {
    foreach (str_split($line) as $j => $char) {
        $bits[$j] += $char == "1" ? 1 : -1;
    }
}

$gamma_bin = $epsilon_bin = "";
foreach ($bits as $i => $value) {
    $gamma_bin .= $value <= 0 ? "0" : "1";
    $epsilon_bin .= $value <= 0 ? "1" : "0";
}

$gamma_dec = bindec($gamma_bin);
$epsilon_dec = bindec($epsilon_bin);

print "gamma: {$gamma_bin} ({$gamma_dec})\nepsilon: ${epsilon_bin} ({$epsilon_dec})\n";
print "result: " . $gamma_dec * $epsilon_dec;
