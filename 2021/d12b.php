<?php

$lines = file("input/d12.txt", FILE_IGNORE_NEW_LINES);

$map = [];
foreach($lines as $line) {
    [$a, $b] = explode('-', $line);
    $map[$a] = array_key_exists($a, $map) ? array_merge($map[$a], [$b]) : [$b];
    $map[$b] = array_key_exists($b, $map) ? array_merge($map[$b], [$a]) : [$a];
}

function handleCave($current_cave, $path, &$map, &$special_small_cave) {
    if ($current_cave == 'end') {
        array_push($path, $current_cave);
        return [$path];
    }
    $dests = [];
    foreach ($map[$current_cave] as $dest) {
        if (!in_array($dest, $path)) {
            $dests[] = $dest;
        } else if (ctype_upper($dest)) {
            $dests[] = $dest;
        } else if ($dest == $special_small_cave && in_array($dest, $path) && array_count_values($path)[$dest] == 1) {
            $dests[] = $dest;
        }
    }
    if (count($dests) == 0) {
        return [];
    }

    array_push($path, $current_cave);
    $new_paths = [];
    foreach($dests as $dest) {
        $paths = handleCave($dest, $path, $map, $special_small_cave);
        if (count($paths)) {
            array_push($new_paths, ...$paths);
        }
    }
    return $new_paths;
}

$paths = [];
foreach(array_keys($map) as $cave) {
    if (ctype_lower($cave) >= 97 && $cave !== 'start') {
        array_push($paths, ...handleCave('start', [], $map, $cave));
        $paths = array_unique($paths, SORT_REGULAR);
    }
}

print "number of paths: " . count($paths);
