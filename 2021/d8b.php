<?php

$lines = file("input/d8.txt", FILE_IGNORE_NEW_LINES);

function getSignals($patterns) {
    $signals = array_fill(0, 10, []);
    usort($patterns, function ($a, $b) {
        return strlen($a) - strlen($b);
    });

    // 1, 4, 7, 8
    $signals[1] = str_split(array_shift($patterns));
    $signals[7] = str_split(array_shift($patterns));
    $signals[4] = str_split(array_shift($patterns));
    $signals[8] = str_split(array_pop($patterns));

    // 3
    foreach([0, 1, 2] as $i) {
        if (count(array_diff(str_split($patterns[$i]), $signals[7])) == 2) {
            $signals[3] = str_split($patterns[$i]);

            array_splice($patterns, $i, 1);
            break;
        }
    }

    // 9
    foreach($patterns as $j => $pattern) {
        if (strlen($pattern) == 6) {
            $newchars = array_diff(str_split($pattern), $signals[3]);
            if (count($newchars) == 1) {
                $signals[9] = str_split($pattern);
                array_splice($patterns, $j, 1);
                break;
            }
        }
    }


    // 5, 6
    foreach($patterns as $k => $pattern) {
        if (strlen($pattern) == 5) {
            $newchars = array_diff($signals[9], str_split($pattern));
            if (count($newchars) == 1) {
                $signals[5] = str_split($pattern);
                array_splice($patterns, $k, 1);
                $signals[2] = str_split(array_shift($patterns));
                break;
            }
        }
    }

    // 0, 6
    if (count(array_diff(str_split($patterns[0]), $signals[1])) == 4) {
        $signals[0] = str_split($patterns[0]);
        $signals[6] = str_split($patterns[1]);
    } else {
        $signals[0] = str_split($patterns[1]);
        $signals[6] = str_split($patterns[0]);
    }

    return $signals;
}

$sum = 0;
foreach($lines as $line) {
    [$pattern_string, $value_string] = explode(" | ", $line);
    $patterns = explode(" ", trim($pattern_string));
    $values = explode(" ", trim($value_string));
    $signals = getSignals($patterns);

    $v = '';
    foreach($values as $value) {
        foreach($signals as $s => $signal) {
            if (strlen($value) == count($signal) && !array_diff(str_split($value), $signal)) {
                $v .= strval($s);
            }
        }
    }
    $sum += intval($v);
}

print "sum of each output value: " . $sum;
