<?php

$filename = "input/d1.txt";
$lines = file($filename);

$increases = 0;
for ($i = 0; $i < count($lines) - 1; $i++) {
    $a = intval(trim($lines[$i]));
    $b = intval(trim($lines[$i + 1]));
    if ($a < $b) {
        $increases += 1;
    }
}

echo $increases;
