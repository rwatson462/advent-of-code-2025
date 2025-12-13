<?php

$input = explode("\n\n", file_get_contents(__DIR__ . '/real-input'));
$treeConfigs = explode("\n", trim(array_pop($input)));

$sizes = array_map(
    // cheap way of counting the size of a present
    // count the number of # characters in it
    callback: fn (string $present) => substr_count($present, '#'),
    array: $input,
);

$answer = 0;

foreach ($treeConfigs as $treeConfig) {
    [$area, $counts] = explode(': ', $treeConfig);

    [$x, $y] = explode('x', $area);
    $treeArea = (int)$x * (int)$y;

    $counts = array_map(intval(...), explode(' ', $counts));

    $minPresentSize = 0;
    foreach ($counts as $idx => $count) {
        // idx is also the index in the presents list
        // count is the number of those presents
        $minPresentSize += $sizes[$idx] * $count;
    }

    if ($minPresentSize < $treeArea) {
        $answer++;
    }
}

echo "Answer: $answer\n";
