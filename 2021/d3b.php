<?php

$lines = file("./input/d3.txt", FILE_IGNORE_NEW_LINES);

function reduce_by_common_bit($values, $invert)
{
    $i = 0;
    do {
        $values = filter_for_position($values, $i, $invert);
        $i += 1;
    } while (count($values) > 1);
    return $values[0];
}

function filter_for_position($lines, $pos, $invert)
{
    $count = 0;
    foreach ($lines as $_ => $line) {
        $count += $line[$pos] == "1" ? 1 : -1;
    }
    if ($invert) {
        $flag = $count < 0 ? "1" : "0";
    } else {
        $flag = $count >= 0 ? "1" : "0";
    }
    $filtered_lines = [];
    foreach ($lines as $_ => $line) {
        if(substr($line, $pos, 1) == $flag) {
            $filtered_lines[] = $line;
        }
    };
    return $filtered_lines;
}

$oxygen_bin = reduce_by_common_bit($lines, false);
$co2_bin = reduce_by_common_bit($lines, true);

$oxygen_dec = bindec($oxygen_bin);
$co2_dec = bindec($co2_bin);

print "oxygen: {$oxygen_bin} ({$oxygen_dec})\nco2: ${co2_bin} ({$co2_dec})\n";
print "result: " . $oxygen_dec * $co2_dec;
