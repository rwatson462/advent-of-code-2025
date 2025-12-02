<?php

$input = file(__DIR__ . '/real-input');
$input = array_merge(...array_map(fn ($line) => explode(',', $line), $input));

$answer = 0;

foreach ($input as $line) {
    [$first, $last] = explode('-', $line);

    // For each "number" check if all digits are the same
    for ($i = (int)$first; $i <= (int)$last; $i++) {
        $str = (string)$i;
        $strlen = strlen($str);

        // Split into ever increasing portions and check if all the portions are the same number
        for ($pieces = 2; $pieces <= $strlen; $pieces++) {
            
            if ($strlen % $pieces !== 0) {
                // The string doesn't break into an exact set of pieces, e.g. strlen of 4 splitting into 3 pieces
                continue;
            }
            
            // Shouldn't have a fraction because of the check above
            $len = (int) ($strlen / $pieces);

            if ($len > $strlen/2) {
                // Once we hit halfway through the string, we do not need to continue
                break;
            }

            $firstPiece = substr($str, 0, $len);

            for($piece = 1; $piece < $pieces; $piece++) {
                $nextPiece = substr($str, $piece*$len, $len);

                if ($nextPiece !== $firstPiece) {
                    // No match, skip any further pieces in thie $piece
                    continue 2;
                }
            }

            // We didn't skip out of here, so the pieces must all match
            $answer += $i;
            // Don't check any more pieces for this $str
            continue 2;
        }
    }
}

echo "Answer: $answer\n";
