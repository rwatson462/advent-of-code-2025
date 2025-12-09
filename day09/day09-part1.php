<?php

$coords = array_map(
    fn (string $line) => array_map(intval(...), explode(',', trim($line))),
    file(__DIR__ . '/real-input'),
);

# using any 2 points on the grid, make the largest rectangle possible
# naive approach:
#   starting with the first point, calculate the area of a rectangle using every other point
#   if the area is larger than the previous, store that result

$largest = 0;

for ($i = 0; $i < count($coords)-1; $i++) {
    $first = $coords[$i];
    for ($j = $i + 1; $j < count($coords); $j++) {
        $second = $coords[$j];
        # Add 1 to include the border
        $area = abs($first[0] - $second[0] + 1) * abs($first[1] - $second[1] + 1);
        $largest = max($largest, $area);
    }
}

echo "Answer: $largest\n";
