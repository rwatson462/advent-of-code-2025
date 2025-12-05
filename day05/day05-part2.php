<?php

$input = file_get_contents(__DIR__ . '/real-input');
[$ranges, $ingredients] = explode("\n\n", $input, 2);
$ranges = explode("\n", trim($ranges));
$ranges = array_map(fn ($line) => explode('-', trim($line)), $ranges);

for ($r = 0; $r < count($ranges)-1; $r++) {
    if ($ranges[$r] === null) continue;

    [$rStart, $rEnd] = $ranges[$r];

    for ($rr = $r+1; $rr < count($ranges); $rr++) {
        if ($ranges[$rr] === null) continue;

        [$rrStart, $rrEnd] = $ranges[$rr];

        // first range is completely inside second range - delete first range
        if ($rStart >= $rrStart && $rEnd <= $rrEnd) {
            $ranges[$r] = null;
            continue;
        }

        // second range is completely inside first range - delete second range
        if ($rrStart >= $rStart && $rrEnd <= $rEnd) {
            $ranges[$rr] = null;
            continue;
        }

        // first range starts before second range - move second range start, delete first range
        if ($rStart <= $rrStart && $rEnd >= $rrStart) {
            $ranges[$rr][0] = $rStart;
            $ranges[$r] = null;
            continue;
        }

        // first range ends after second range - move second range end, delete first range
        if ($rEnd >= $rrEnd && $rStart <= $rrEnd) {
            $ranges[$rr][1] = $rEnd;
            $ranges[$r] = null;
            continue;
        }

        // ranges don't overlap - ignore
    }
}

$ans = array_reduce(
    array: array_filter($ranges),
    callback: fn ($carry, $range) => $carry + $range[1] - $range[0] + 1,
    initial: 0
);

echo "Answer: $ans\n";
