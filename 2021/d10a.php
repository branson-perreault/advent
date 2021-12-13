<?php

$lines = file("input/d10.txt", FILE_IGNORE_NEW_LINES);

$opening_braces = ['(', '[', '{', '<'];
$closing_braces = [')', ']', '}', '>'];
$scores = [
    ')' => 3,
    ']' => 57,
    '}' => 1197,
    '>' => 25137
];
$score = 0;
foreach($lines as $line) {
    $current_stack = [];
    foreach(str_split($line) as $i => $char) {
        if (in_array($char, $opening_braces)) {
            array_push($current_stack, $char);
            continue;
        }
        $mate = array_pop($current_stack);
        if ($mate and array_search($mate, $opening_braces) == array_search($char, $closing_braces)) {
            continue;
        }
        $score += $scores[$char];
        break;
    }
}

print "compiler score: $score\n";
