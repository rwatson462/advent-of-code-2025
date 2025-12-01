<?php

function example() {
    return [
        'L68',
        'L30',
        'R48',
        'L5',
        'R60',
        'L55',
        'L1',
        'L99',
        'R14',
        'L82',
    ];
}

function puzzle() {
    $input = explode("\n", file_get_contents('day01-input'));

    return array_map(
        callback: trim(...),
        array: $input,
    );
}

$start = 50;
$zeroCount = 0;

$input = puzzle();

foreach($input as $instruction) {
    $dir = $instruction[0];
    $amt = (int) substr($instruction, 1);

    // if dir === 'L', subtract
    // if dir === 'R', add
    if ($dir === 'L') {
        $amt *= -1;
    }

    $start += $amt;
    
    // wrap to between 0 and 99
    while ($start < 0) $start += 100;
    while ($start > 99) $start -= 100;

    // part 1: if we land on exactly zero, count it
    if ($start === 0) $zeroCount++;
}

printf("Number of times zero was hit: %d\n", $zeroCount);