<?php

function step1(&$octomap) {
    foreach($octomap as $y => $octoline) {
        foreach($octoline as $x => $octo) {
            $octomap[$y][$x] = $octo + 1;
        }
    }
}

function step2(&$octomap) {
    $octos_to_reset = [];
    $octos_to_flash = [];
    foreach($octomap as $y => $octoline) {
        foreach($octoline as $x => $octo) {
            if ($octo > 9) {
                array_push($octos_to_reset, [$x, $y]);
                array_push($octos_to_flash, [$x, $y]);
            }
        }
    }

    while(count($octos_to_flash) > 0) {
        [$x, $y] = array_shift($octos_to_flash);

        $has_left = $x > 0;
        $has_right = $x < count($octomap[0]) - 1;
        $has_up = $y > 0;
        $has_down = $y < count($octomap) - 1;
        if ($has_left) {
            $octomap[$y][$x - 1] += 1;
            if ($octomap[$y][$x - 1] > 9 && !in_array([$x - 1, $y], $octos_to_reset)) {
                array_push($octos_to_reset, [$x - 1, $y]);
                array_push($octos_to_flash, [$x - 1, $y]);
            }
        }
        if ($has_right) {
            $octomap[$y][$x + 1] += 1;
            if ($octomap[$y][$x + 1] > 9 && !in_array([$x + 1, $y], $octos_to_reset)) {
                array_push($octos_to_reset, [$x + 1, $y]);
                array_push($octos_to_flash, [$x + 1, $y]);
            }
        }
        if ($has_up) {
            $octomap[$y - 1][$x] += 1;
            if ($octomap[$y - 1][$x] > 9 && !in_array([$x, $y - 1], $octos_to_reset)) {
                array_push($octos_to_reset, [$x, $y - 1]);
                array_push($octos_to_flash, [$x, $y - 1]);
            }
        }
        if ($has_down) {
            $octomap[$y + 1][$x] += 1;
            if ($octomap[$y + 1][$x] > 9 && !in_array([$x, $y + 1], $octos_to_reset)) {
                array_push($octos_to_reset, [$x, $y + 1]);
                array_push($octos_to_flash, [$x, $y + 1]);
            }
        }
        if ($has_left && $has_up) {
            $octomap[$y - 1][$x - 1] += 1;
            if ($octomap[$y - 1][$x - 1] > 9 && !in_array([$x - 1, $y - 1], $octos_to_reset)) {
                array_push($octos_to_reset, [$x - 1, $y - 1]);
                array_push($octos_to_flash, [$x - 1, $y - 1]);
            }
        }
        if ($has_up && $has_right) {
            $octomap[$y - 1][$x + 1] += 1;
            if ($octomap[$y - 1][$x + 1] > 9 && !in_array([$x + 1, $y - 1], $octos_to_reset)) {
                array_push($octos_to_reset, [$x + 1, $y - 1]);
                array_push($octos_to_flash, [$x + 1, $y - 1]);
            }
        }
        if ($has_right && $has_down) {
            $octomap[$y + 1][$x + 1] += 1;
            if ($octomap[$y + 1][$x + 1] > 9 && !in_array([$x + 1, $y + 1], $octos_to_reset)) {
                array_push($octos_to_reset, [$x + 1, $y + 1]);
                array_push($octos_to_flash, [$x + 1, $y + 1]);
            }
        }
        if ($has_down && $has_left) {
            $octomap[$y + 1][$x - 1] += 1;
            if ($octomap[$y + 1][$x - 1] > 9 && !in_array([$x - 1, $y + 1], $octos_to_reset)) {
                array_push($octos_to_reset, [$x - 1, $y + 1]);
                array_push($octos_to_flash, [$x - 1, $y + 1]);
            }
        }
    }

    return $octos_to_reset;
}

function step3(&$octomap, $octos_to_reset) {
    $count = count($octos_to_reset);
    foreach($octos_to_reset as [$x, $y]) {
        $octomap[$y][$x] = 0;
    }
    return $count;
}

function printMap(&$octomap) {
    foreach($octomap as $octoline) {
        print join('', $octoline) . "\n";
    }
    print "\n";
}

$octomap = file("input/d11.txt", FILE_IGNORE_NEW_LINES);
foreach($octomap as $i => $octoline) {
    $octomap[$i] = str_split($octoline);
}

$steps = 0;
do {
    step1($octomap);
    $octos_to_reset = step2($octomap);
    $flashes = step3($octomap, $octos_to_reset);
    $steps++;
} while ($flashes < count($octomap) * count($octomap[0]));

print "all octos synchronized after $steps step(s)\n";
