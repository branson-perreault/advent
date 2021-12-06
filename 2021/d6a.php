<?php

$fishes = explode(",", file("input/d6.txt", FILE_IGNORE_NEW_LINES)[0]);

for($day = 1; $day <= 80; $day++) {
    $newfishes = [];
    for($i = 0; $i < count($fishes); $i++) {
        $fishes[$i] -= 1;
        if ($fishes[$i] < 0) {
            $newfishes[] = 8;
            $fishes[$i] = 6;
        }
    }
    array_push($fishes, ...$newfishes);
}

print "total after " . ($day - 1) . " days: " . count($fishes);
