<?php

$input = file(__DIR__ . '/real-input');
$input = array_merge(...array_map(fn ($line) => explode(',', $line), $input));

$answer = 0;

foreach ($input as $line) {
    [$first, $last] = explode('-', $line);

    // For each "number" check if it's made of 2 equal halves of the same number (e.g. 11 = 1 + 1)
    for ($i = (int)$first; $i <= (int)$last; $i++) {
        $str = (string)$i;

        // Must be 2 groups of the same digits, therefore odd lengths can be ignored
        if (strlen($i) % 2 !== 0 ) {
            continue;
        }

        // First half must be same as second half
        $firstHalf = substr($str, 0, strlen($str) / 2);
        $secondHalf = substr($str, strlen($str) / 2);

        if ($firstHalf !== $secondHalf) {
            continue;
        }

        $answer += $i;
    }
}

echo "Answer: $answer\n";
