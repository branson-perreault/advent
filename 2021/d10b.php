<?php

$lines = file("input/d10.txt", FILE_IGNORE_NEW_LINES);

$opening_braces = ['(', '[', '{', '<'];
$closing_braces = [')', ']', '}', '>'];

$autocomplete_scores = [
    '(' => 1,
    '[' => 2,
    '{' => 3,
    '<' => 4
];
$autocomplete_scores_by_line = [];

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
        $current_stack = [];
        break;
    }

    if (count($current_stack) > 0) {
        $autocomplete_score = 0;
        foreach(array_reverse($current_stack) as $brace) {
            $autocomplete_score *= 5;
            $autocomplete_score += $autocomplete_scores[$brace];
        }
        $autocomplete_scores_by_line[] = $autocomplete_score;
    }
}

sort($autocomplete_scores_by_line);
$final_autocomplete_score = $autocomplete_scores_by_line[(count($autocomplete_scores_by_line) - 1) / 2];

print "autocomplete score: $final_autocomplete_score\n";
