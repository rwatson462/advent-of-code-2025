<?php

require_once dirname(__DIR__) . '/load-file.php';
$input = loadFile(__DIR__ . '/real-input');

$start = 50;
$zeroCount = 0;

foreach($input as $instruction) {
    $dir = $instruction[0];
    $amt = (int) substr($instruction, 1);

    // if dir === 'L', subtract
    // if dir === 'R', add
    if ($dir === 'L') {
        $amt *= -1;
    }

    // hack to stop us counting twice when we're ON zero then go below it
    if ($start === 0 && $start + $amt < 0) {
        $zeroCount--;
    }

    $start += $amt;
    
    // wrap to between 0 and 99
    while ($start < 0) {
        $start += 100;
        $zeroCount ++;
    }
    while ($start > 100){
        $start -= 100;
        $zeroCount ++;
    }
    // hack to stop us counting twice when we're ON 100 (zero) exactly
    if ($start === 100) {
        $start = 0;
    }

    if ($start === 0) {
        $zeroCount++;
    }
}

printf("Number of times zero was hit: %d\n", $zeroCount);