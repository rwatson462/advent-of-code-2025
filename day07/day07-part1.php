<?php

$input = array_map(
    fn(string $line) => str_split(trim($line)),
    file(__DIR__ . '/real-input'),
);

const LASER = 'S';
const SPLITTER = '^';
const SPACE = '.';

$answer = 0;
$cols = count($input[0]);

// start tracking from the second row so we always have a previous row
for ($row = 1; $row < count($input); $row++) {
    $prevRow = $row-1;

    for ($col = 0; $col < $cols; $col++) {
        if ($input[$prevRow][$col] === LASER) {
            if ($input[$row][$col] === SPLITTER) {
                $input[$row][$col - 1] = LASER;
                $input[$row][$col + 1] = LASER;
                $answer++;
                continue;
            }
            if ($input[$row][$col] === SPACE) {
                $input[$row][$col] = LASER;
            }
        }
    }
}

echo "Answer:  $answer\n";
