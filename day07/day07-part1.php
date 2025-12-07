<?php

$input = array_map(
    fn(string $line) => str_split(trim($line)),
    file(__DIR__ . '/real-input'),
);

function printGrid(array $grid): void
{
    echo implode("\n", array_map(fn(array $row) => implode('', $row), $grid)) . "\n\n";
}

$splits = 0;
const LASER = 'S';
const SPLITTER = '^';
const SPACE = '.';

for ($cur = 1; $cur < count($input); $cur++) {
    $cols = count($input[$cur]);
    $prev = $cur-1;
    // find any laser positions above (S) and pull them down to the current row
    // if the space they would go into is a splitter (^):
    //    place lasers either side of the splitter
    //    increment the splitter counter
    for ($col = 0; $col < $cols; $col++) {
        if ($input[$prev][$col] === LASER) {
            if ($input[$cur][$col] === SPLITTER) {
                $input[$cur][$col - 1] = LASER;
                $input[$cur][$col + 1] = LASER;
                $splits++;
                continue;
            }
            if ($input[$cur][$col] === SPACE) {
                $input[$cur][$col] = LASER;
            }
        }
    }
}

echo "Answer:  $splits\n";
