<?php

function printSheet(&$sheet) {
    foreach($sheet as $line) {
        print join("", $line) . "\n";
    }
    print "\n";
}

$lines = file("input/d13.txt", FILE_IGNORE_NEW_LINES);

$dots = [];
$folds = [];
$max_x = 0;
$max_y = 0;

foreach($lines as $line) {
    if (ctype_digit(substr($line, 0, 1))) {
        [$x, $y] = explode(',', $line);
        $dots[] = [$x, $y];
        $max_x = max($x, $max_x);
        $max_y = max($y, $max_y);
    }
    if (ctype_alpha(substr($line, 0, 1))) {
        $folds[] = explode("=", explode("fold along ", $line)[1]);
    }
}

$sheet = array_fill(0, $max_y + 1, array_fill(0, $max_x + 1, '.'));
foreach ($dots as [$x, $y]) {
    $sheet[$y][$x] = '#';
}

function fold($axis, $line, &$sheet) {
    if ($axis == "y") {
        for ($y = $line + 1; $y < count($sheet); $y++) {
            for ($x = 0; $x < count($sheet[0]); $x++) {
                if ($sheet[$y][$x] == '#' || $sheet[$line - ($y - $line)][$x] == '#') {
                    $sheet[$line - ($y - $line)][$x] = '#';
                }
            }
        }
        $sheet = array_slice($sheet, 0, $line);
    }
    if ($axis == "x") {
        for ($y = 0; $y < count($sheet); $y++) {
            for($x = $line + 1; $x < count($sheet[$y]); $x++) {
                if ($sheet[$y][$x] == '#' || $sheet[$y][$line - ($x - $line)] == '#') {
                    $sheet[$y][$line - ($x - $line)] = '#';
                }
            }
            $sheet[$y] = array_slice($sheet[$y], 0, $line);
        }
    }
}

fold($folds[0][0], intval($folds[0][1]), $sheet);
$num_dots = array_count_values(array_merge(...array_values($sheet)))['#'];
print "number of visible dots: $num_dots\n\n";

for ($i = 1; $i < count($folds); $i++) {
    fold($folds[$i][0], intval($folds[$i][1]), $sheet);
}
printSheet($sheet);
