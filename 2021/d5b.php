<?php

$lines = file("input/d5.txt", FILE_IGNORE_NEW_LINES);

$map = [];

function get_line($x1, $y1, $x2, $y2): array {
    $line = [];
    if ($x1 == $x2) {
        for ($y = min($y1, $y2); $y <= max($y1, $y2); $y++) {
            $line[] = "{$x1},{$y}";
        }
    } else if ($y1 == $y2) {
        for ($x = min($x1, $x2); $x <= max($x1, $x2); $x++) {
            $line[] = "{$x},{$y1}";
        }
    } else {
        $x = $x1;
        $y = $y1;
        while ($x != $x2) {
            $line[] = "{$x},{$y}";
            $x += $x1 < $x2 ? 1 : -1;
            $y += $y1 < $y2 ? 1 : -1;
        }
        $line[] = "{$x},{$y}";
    }
    return $line;
}

$count = 0;
foreach ($lines as $i => $line) {
    [$start, $end] = explode(" -> ", $line, 2);
    [$start_x, $start_y] = array_map('intval', explode(",", $start, 2));
    [$end_x, $end_y] = array_map('intval', explode(",", $end, 2));

    foreach (get_line($start_x, $start_y, $end_x, $end_y) as $_ => $point) {
        $map[$point] = array_key_exists($point, $map) ? $map[$point] + 1 : 1;
        if ($map[$point] == 2) {
            $count++;
        }
    }
}

print("overlapping points: {$count}");
