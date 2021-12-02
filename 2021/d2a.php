<?php

$lines = file("input/d2.txt");

$distance = 0;
$depth = 0;
foreach ($lines as $i => $line) {
    [$instruction, $amountstr] = explode(" ", $line);
    $amount = intval(trim($amountstr));

    switch ($instruction) {
        case "forward":
            $distance += $amount;
            break;
        case "down":
            $depth += $amount;
            break;
        case "up":
            $depth = max(0, $depth - $amount);
            break;
        default:
            break;
    }
}

print("distance: " . $distance . ", depth: " . $depth . "\nproduct: " . $distance * $depth);
