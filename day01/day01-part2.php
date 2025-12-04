<?php

$input = file(__DIR__ . '/real-input');

$start = 50;
$zeroCount = 0;

foreach($input as $instruction) {
    $dir = $instruction[0];
    $amt = (int) substr($instruction, 1);

    // just turn the knob 1 click at a time and check for zero after each click
    while ($amt > 0) {
        $start += $dir === 'L' ? -1 : 1;
        $start = ($start + 100) % 100;
        $amt --;

        if ($start === 0) {
            $zeroCount++;
        }
    }
}

printf("Number of times zero was hit: %d\n", $zeroCount);
