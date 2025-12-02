<?php

$input = file(__DIR__ . '/real-input');

$start = 50;
$zeroCount = 0;

foreach($input as $instruction) {
    $dir = $instruction[0];
    $amt = (int) substr($instruction, 1);

    $start += $dir === 'L'
        ? -$amt
        : $amt;
    
    // wrap to between 0 and 99
    $start = ($start + 100) % 100;

    // part 1: if we land on exactly zero, count it
    if ($start === 0) $zeroCount++;
}

printf("Number of times zero was hit: %d\n", $zeroCount);
