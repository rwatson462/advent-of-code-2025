<?php

$input = file(__DIR__ . '/real-input');

$answer = 0;

foreach($input as $line) {
    $numbers = array_map(intval(...), str_split(trim($line)));

    $bankSize = count($numbers);
    $top = $next = 0;
    for ($idx = 0; $idx < count($numbers); $idx++) {
        $number = $numbers[$idx];

        if ($idx < $bankSize - 1 && $number > $top) {
            $top = $number;
            $next = 0;
            continue;
        }

        if ($number > $next) {
            $next = $number;
        }
    }

    $joltage = (int)"$top$next";
    $answer += $joltage;
}

echo "Answer: $answer\n";
