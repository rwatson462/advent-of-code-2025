<?php

$input = file_get_contents(__DIR__ . '/real-input');
$ranges = array_map(
    callback: fn ($line) => explode('-', trim($line)),
    array: explode("\n", explode("\n\n", $input, 2)[0])
);
sort($ranges);

for ($r = 0; $r < count($ranges)-1; $r++) {
    if ($ranges[$r] === null) continue;

    [$rStart, $rEnd] = $ranges[$r];

    for ($rr = $r+1; $rr < count($ranges); $rr++) {
        if ($ranges[$rr] === null) continue;

        [$rrStart, $rrEnd] = $ranges[$rr];

        if ($rrStart > $rEnd) {
            // no overlap, these 2 ranges can coexist
            continue;
        }

        // set end to max of both ends
        $ranges[$r][1] = $rEnd = max($rEnd, $rrEnd);
        $ranges[$rr] = null;
    }
}

/**
 * Example: 10 -> 20 has 11 numbers.  20-10 === 10, so you have to +1 after
 */
$ans = array_reduce(
    array: array_filter($ranges),
    callback: fn ($carry, $range) => $carry + $range[1] - $range[0] + 1,
    initial: 0
);

echo "Answer: $ans\n";
