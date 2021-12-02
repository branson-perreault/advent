<?php

$filename = "input/d1.txt";
$lines = file($filename);

$increases = 0;
for ($i = 0; $i < count($lines) - 3; $i++) {
    $a = intval(trim($lines[$i]));
    $b = intval(trim($lines[$i + 1]));
    $c = intval(trim($lines[$i + 2]));
    $d = intval(trim($lines[$i + 3]));

    $first = $a + $b + $c;
    $second = $b + $c + $d;
    if ($first < $second) {
        $increases += 1;
    }
}

echo $increases;
