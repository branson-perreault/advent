<?php

$lines = file("input/d2.txt");

$distance = $depth = $aim = 0;
for ($i = 0; $i < count($lines); $i++) {
    [$instruction, $amountstr] = explode(" ", $lines[$i]);
    $amount = intval(trim($amountstr));

    switch ($instruction) {
        case "down":
            $aim += $amount;
            break;
        case "up":
            $aim -= $amount;
            break;
        case "forward":
            $distance += $amount;
            $depth = max(0, $depth + ($aim * $amount));
            break;
        default:
            break;
    }
}

print("distance: " . $distance . ", depth: " . $depth . "\nproduct: " . $distance * $depth);
