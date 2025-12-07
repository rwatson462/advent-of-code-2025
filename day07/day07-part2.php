<?php

$input = array_map(
    fn(string $line) => str_split(trim($line)),
    file(__DIR__ . '/real-input'),
);

const LASER = 'S';
const SPLITTER = '^';
const SPACE = '.';

$laserPowers = [];
$cols = count($input[0]);

for ($row = 1; $row < count($input); $row++) {
    $prevRow = $row-1;

    for ($col = 0; $col < $cols; $col++) {
        if ($input[$prevRow][$col] === LASER) {
            if ($input[$row][$col] === SPLITTER) {
                // get the power of the laser coming into the splitter
                $power = $laserPowers[$col] ?? 1;

                // mark the position of the split laser
                $input[$row][$col - 1] = LASER;
                $input[$row][$col + 1] = LASER;

                // add the laser's power to our tracker
                $laserPowers[$col-1] = ($laserPowers[$col-1] ?? 0) + $power;
                $laserPowers[$col+1] = ($laserPowers[$col+1] ?? 0) + $power;

                // remove the laser that we're splitting from the tracker
                unset($laserPowers[$col]);
                continue;
            }
            if ($input[$row][$col] === SPACE) {
                $input[$row][$col] = LASER;
            }
        }
    }
}

$timelines = array_sum($laserPowers);

echo "Answer:  $timelines\n";
