<?php

$lines = file("input/d8.txt", FILE_IGNORE_NEW_LINES);

$count = 0;
foreach($lines as $line) {
    [$pattern_string, $value_string] = explode(" | ", $line);
    $patterns = explode(" ", trim($pattern_string));
    $values = explode(" ", trim($value_string));
    $signals = array_fill(0, 10, []);
    foreach($patterns as $pattern) {
        switch(strlen($pattern)) {
            case 2:
                $signals[1] = str_split($pattern);
                break;
            case 3:
                $signals[7] = str_split($pattern);
                break;
            case 4:
                $signals[4] = str_split($pattern);
                break;
            case 7:
                $signals[8] = str_split($pattern);
                break;
        }
    }

    foreach($values as $value) {
        foreach([1, 4, 7, 8] as $digit) {
            $signal = $signals[$digit];
            $chars = str_split($value);
            $same = (count($signal) == count($chars) && !array_diff($signal, $chars));
            if ($same) {
                $count++;
            }
        }
    }
}

print "total number of 1s, 4s, 7, and 8s: " . $count;
