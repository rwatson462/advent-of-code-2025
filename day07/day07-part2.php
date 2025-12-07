<?php

$input = array_map(
    fn(string $line) => str_split(trim($line)),
    file(__DIR__ . '/real-input'),
);

function printGrid(array $grid): void
{
    echo implode("\n", array_map(fn(array $row) => implode('', $row), $grid)) . "\n\n";
}

const LASER = 'S';
const SPLITTER = '^';
const SPACE = '.';

$laserPowers = [];

for ($cur = 1; $cur < count($input); $cur++) {
    $cols = count($input[$cur]);
    $prev = $cur-1;

    for ($col = 0; $col < $cols; $col++) {
        if ($input[$prev][$col] === LASER) {
            if ($input[$cur][$col] === SPLITTER) {
                // get the power of the laser coming into the splitter
                $power = $laserPowers[$col] ?? 1;

                // mark the position of the split laser
                $input[$cur][$col - 1] = LASER;
                $input[$cur][$col + 1] = LASER;

                // add the laser's power to our tracker
                $laserPowers[$col-1] = ($laserPowers[$col-1] ?? 0) + $power;
                $laserPowers[$col+1] = ($laserPowers[$col+1] ?? 0) + $power;

                // remove the laser that we're splitting from the tracker
                unset($laserPowers[$col]);
                continue;
            }
            if ($input[$cur][$col] === SPACE) {
                $input[$cur][$col] = LASER;
            }
        }
    }
}

$timelines = array_sum($laserPowers);

echo "Answer:  $timelines\n";
