<?php

$lines = file("input/d12.txt", FILE_IGNORE_NEW_LINES);

$map = [];
foreach($lines as $line) {
    [$a, $b] = explode('-', $line);
    $map[$a] = array_key_exists($a, $map) ? array_merge($map[$a], [$b]) : [$b];
    $map[$b] = array_key_exists($b, $map) ? array_merge($map[$b], [$a]) : [$a];
}


function handleNode($node, $path, &$map) {
    if ($node == 'end') {
        array_push($path, $node);
        return [$path];
    }
    $dests = [];
    foreach ($map[$node] as $dest) {
        if (!in_array($dest, $path)) {
            $dests[] = $dest;
        } else if (ctype_upper($dest)) {
            $dests[] = $dest;
        }
    }
    if (count($dests) == 0) {
        return [];
    }

    array_push($path, $node);
    $new_paths = [];
    foreach($dests as $dest) {
        $paths = handleNode($dest, $path, $map);
        if (count($paths)) {
            array_push($new_paths, ...$paths);
        }
    }
    return $new_paths;
}

$paths = handleNode('start', [], $map);

print "number of paths: " . count($paths);
