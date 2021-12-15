<?php

$lines = file("input/d14.txt", FILE_IGNORE_NEW_LINES);
$template = str_split($lines[0]);
$insertion_rules = [];
for($i = 2; $i < count($lines); $i++) {
    [$in, $out] = explode(" -> ", $lines[$i], 2);
    $insertion_rules[$in] = $out;
}

$steps = 10;
for ($n = 0; $n < $steps; $n++) {
    for($i = 0; $i < count($template) - 1; $i += 2) {
        $pair = array_slice($template, $i, 2);
        $to_insert = $insertion_rules[join("", $pair)];
        array_splice($template, $i + 1, 0, [$to_insert]);
    }
}

$counts = array_count_values($template);
sort($counts);
$result = abs($counts[0] - $counts[count($counts) - 1]);
print "result: $result\n";
