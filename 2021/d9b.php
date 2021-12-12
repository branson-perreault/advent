<?php

$lines = file("input/d9.txt", FILE_IGNORE_NEW_LINES);

function getBounds($x, $y, $lines) {
    $left_bound = $x == 0 ? PHP_INT_MAX : intval($lines[$y][$x - 1]);
    $right_bound = $x == strlen($lines[$y]) - 1 ? PHP_INT_MAX : intval($lines[$y][$x + 1]);
    $up_bound = $y == 0 ? PHP_INT_MAX : intval($lines[$y - 1][$x]);
    $down_bound = $y == count($lines) - 1 ? PHP_INT_MAX : intval($lines[$y + 1][$x]);
    return [$left_bound, $right_bound, $up_bound, $down_bound];
}

function findBasinSize($initial_x, $initial_y, $lines) {
    $points_to_check = ["$initial_x,$initial_y"];
    $points_in_basin = [];
    while ($points_to_check) {
        $point = array_shift($points_to_check);
        [$x, $y] = explode(",", $point);
        [$left_bound, $right_bound, $up_bound, $down_bound] = getBounds($x, $y, $lines);

        $left_coords = ($x - 1) . ",$y";
        if ($left_bound < 9 && !in_array($left_coords, $points_in_basin) && !in_array($left_coords, $points_to_check)) {
            array_push($points_to_check, $left_coords);
        }
        $right_coords = ($x + 1) . ",$y";
        if ($right_bound < 9 && !in_array($right_coords, $points_in_basin) && !in_array($right_coords, $points_to_check)) {
            array_push($points_to_check, $right_coords);
        }
        $up_coords = "$x," . ($y - 1);
        if ($up_bound < 9 && !in_array($up_coords, $points_in_basin) && !in_array($up_coords, $points_to_check)) {
            array_push($points_to_check, $up_coords);
        }
        $down_coords = "$x," . ($y + 1);
        if ($down_bound < 9 && !in_array($down_coords, $points_in_basin) && !in_array($down_coords, $points_to_check)) {
            array_push($points_to_check, $down_coords);
        }
        $points_in_basin[] = $point;
    }
    return count($points_in_basin);
}

$low_points = [];
foreach($lines as $y => $line) {
    foreach(str_split($line) as $x => $point) {
        [$left_bound, $right_bound, $up_bound, $down_bound] = getBounds($x, $y, $lines);
        $point_i = intval($point);
        if ($point_i < $left_bound and $point_i < $right_bound) {
            if ($point_i < $up_bound and $point_i < $down_bound) {
                $low_points["$x,$y"] = $point_i + 1;
            }
        }
    }
}

$sizes = [];
foreach($low_points as $low_point => $val) {
    [$x, $y] = explode(",", $low_point, 2);
    $sizes[] = findBasinSize(intval($x), intval($y), $lines);
}

sort($sizes);
$sizes = array_slice($sizes, count($sizes) - 3);
print "biggest basin sizes: \n";
print join(", ", $sizes) . "\n";
print "result: " . array_product($sizes) . "\n";
