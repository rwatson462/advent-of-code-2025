<?php

$input = file(__DIR__.'/real-input');



function findHighestValue(array $numbers, int $start, int $end): array {
    $highest = $highestIdx = 0;
    for ($i = $start; $i < $end; $i++) {
        if ($numbers[$i] > $highest) {
            $highest = $numbers[$i];
            $highestIdx = $i;
        }
    }
    
    return [
        $highest,
        $highestIdx,
    ];
}


$answer = 0;

$batteryCount = 12;

foreach($input as $line) {
    $numbers = array_map(intval(...), str_split(trim($line)));
    
    $joltageValues = [];

    $bankSize = count($numbers);
    $highestIdx = -1;
    for ($batteriesFound = $batteryCount-1; $batteriesFound >= 0; $batteriesFound--) {
        [$highest, $highestIdx] = findHighestValue($numbers, $highestIdx+1, $bankSize - $batteriesFound);
        $joltageValues[] = $highest;
    }

    $total = (int)implode('', $joltageValues) . "\n";
    $answer += $total;
}



echo "Answer: $answer\n";
