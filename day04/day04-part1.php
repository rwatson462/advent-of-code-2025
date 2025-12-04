<?php

$grid = array_map(
    fn (string $line) => str_split(trim($line)),
    file(__DIR__ . '/example-input'),
);

function isFilled(array $grid, int $x, int $y): int {
    // check for out of bounds first
    if ($y < 0 || $y > count($grid)-1) {
        return 0;
    }
    if ($x < 0 || $x > count($grid[$y])-1) {
        return 0;
    }

    // returning an int means we can just add it to our previous counter
    return (int) isset($grid[$y][$x]) && $grid[$y][$x] === '@';
}

$answer = 0;

// for each position in the grid, count the adjacent positions that contain paper ("@")
// if less than 4 filled positions, count in answer
for ($y = 0; $y < count($grid); $y++) {
    for ($x = 0; $x < count($grid[$y]); $x++) {
        // only consider grid coords that contain paper
        if ($grid[$y][$x] !== '@') continue;

        // check each direction for '@'
        $adjacentCount = 0;

        $adjacentCount += isFilled($grid, $x-1, $y-1);
        $adjacentCount += isFilled($grid, $x, $y-1);
        $adjacentCount += isFilled($grid, $x+1, $y-1);
        $adjacentCount += isFilled($grid, $x-1, $y);
        $adjacentCount += isFilled($grid, $x+1, $y);
        $adjacentCount += isFilled($grid, $x-1, $y+1);
        $adjacentCount += isFilled($grid, $x, $y+1);
        $adjacentCount += isFilled($grid, $x+1, $y+1);

        if ($adjacentCount < 4) $answer++;
    }
}

echo "Answer: $answer\n";
