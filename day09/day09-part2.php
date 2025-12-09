<?php

$redTiles = array_map(
    fn (string $line) => array_map(intval(...), explode(',', trim($line))),
    file(__DIR__ . '/real-input'),
);

# using any 2 points on the grid, make the largest rectangle possible
# naive approach:
#   build a list of all points covered by lines between the red tiles
#   then check if all 4 points of any rectangle made from red tile corners is inside the resulting shape

$largest = 0;

$greenTiles = [];

for ($i = 0; $i < count($redTiles)-1; $i++) {
    $first = $redTiles[$i];
    for ($j = $i; $j < count($redTiles); $j++) {
        $second = $redTiles[$j];
        // add green tiles along straight lines
        if ($first[0] === $second[0]) {
            // x-axis match, so walk through y-axis
            $x = $first[0];
            for ($y = min($first[1], $second[1]); $y <= max($first[1], $second[1]); $y++) {
                $greenTiles[] = [$x, $y];
            }
        } else if ($first[1] === $second[1]) {
            // y-axis match, so walk through x-axis
            $y = $first[1];
            for ($x = min($first[0], $second[0]); $x <= max($first[0], $second[0]); $x++) {
                $greenTiles[] = [$x, $y];
            }
        }

        // no axis alignment
    }
}

function is_green_tile(int $x, int $y): bool {
    global $greenTiles;

    foreach($greenTiles as $tile) {
        if ($tile[0] === $x && $tile[1] === $y) return true;
    }

    return false;
}

function is_red_tile(int $x, int $y): bool {
    global $redTiles;

    foreach($redTiles as $tile) {
        if ($tile[0] === $x && $tile[1] === $y) return true;
    }

    return false;
}

$minX = min(array_column($redTiles, 0));
$maxX = max(array_column($redTiles, 0));
$minY = min(array_column($redTiles, 1));
$maxY = max(array_column($redTiles, 1));

for ($y = $minY; $y <= $maxY; $y++) {
    for ($x = $minX; $x <= $maxX; $x++) {
        if (is_red_tile($x, $y)) {
            echo 'R';
        } else if (is_green_tile($x, $y)) {
            echo 'G';
        } else {
            echo '.';
        }
    }
    echo "\n";
}


// for ($i = 0; $i < count($redTiles)-1; $i++) {
//     $first = $redTiles[$i];
//     for ($j = $i + 1; $j < count($redTiles); $j++) {
//         $second = $redTiles[$j];
//         # Add 1 to include the border
//         $area = abs($first[0] - $second[0] + 1) * abs($first[1] - $second[1] + 1);
//         $largest = max($largest, $area);
//     }
// }

// echo "Answer: $largest\n";
