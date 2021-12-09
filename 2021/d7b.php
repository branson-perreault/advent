<?php

$crabs = fgets(fopen("input/d7.txt", 'r'));
$crabs = explode(",", trim($crabs));

$max = max($crabs);
$min_fuel_cost = PHP_INT_MAX;

for($pos = 0; $pos <= $max; $pos++) {
    $fuel_cost = array_sum(array_map(function($crab) use ($pos) {
        $dist = abs(intval($crab) - $pos);
        return ($dist * ($dist+1)) / 2;
    }, $crabs));
    $min_fuel_cost = min($min_fuel_cost, $fuel_cost);
}

print $min_fuel_cost;
