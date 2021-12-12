<?php

$lines = file("input/d9.txt", FILE_IGNORE_NEW_LINES);

function getBounds($x, $y, $lines) {
    $left_bound = $x == 0 ? PHP_INT_MAX : intval($lines[$y][$x - 1]);
    $right_bound = $x == strlen($lines[$y]) - 1 ? PHP_INT_MAX : intval($lines[$y][$x + 1]);
    $up_bound = $y == 0 ? PHP_INT_MAX : intval($lines[$y - 1][$x]);
    $down_bound = $y == count($lines) - 1 ? PHP_INT_MAX : intval($lines[$y + 1][$x]);
    return [$left_bound, $right_bound, $up_bound, $down_bound];
}

$risks = [];
foreach($lines as $y => $line) {
    foreach(str_split($line) as $x => $point) {
        [$left_bound, $right_bound, $up_bound, $down_bound] = getBounds($x, $y, $lines);
        $point_i = intval($point);
        if ($point_i < $left_bound and $point_i < $right_bound) {
            if ($point_i < $up_bound and $point_i < $down_bound) {
                $risks[] = $point_i + 1;
            }
        }
    }
}

print "num low points: " . count($risks) . "\n";
print "total risk: " . array_sum($risks) . "\n";
