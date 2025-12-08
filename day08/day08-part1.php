<?php

$input = array_map(
    trim(...),
    file(__DIR__ . '/real-input'),
);

function dist(int $x, int $y, int $z): int
{
    return $x * $x + $y * $y + $z * $z;
}

$distances = [];
for ($i = 0; $i < count($input)-1; $i++) {
    $a = $input[$i];
    $ac = array_map(intval(...), explode(',', $a));

    for ($d = $i + 1; $d < count($input); $d++) {
        $b = $input[$d];
        $bc = array_map(intval(...), explode(',',$b));

        $distances["$a-$b"] = dist(
            x: abs($ac[0] - $bc[0]),
            y: abs($ac[1] - $bc[1]),
            z: abs($ac[2] - $bc[2]),
        );
    }
}

asort($distances);

echo "Calculated ".count($distances)." distances\n";

# todo change to 1000 for real input
array_splice($distances, 1000);

// build circuits using the closest boxes that aren't already in a circuit
$circuits = [];
$connections = 0;

foreach ($distances as $next => $_) {
    [$a, $b] = explode('-', $next);

    foreach ($circuits as $circuit) {
        if (in_array($a, $circuit) && in_array($b, $circuit)) {
            // we have already added both of these to the same circuit
            continue 2;
        }
    }

    // if not, attach to a circuit
    $found = false;
    for ($c = 0; $c < count($circuits); $c++) {
        $circuit = $circuits[$c];
        if (in_array($a, $circuit)) {
            $circuits[$c][] = $b;
            $found = true;
            break;
        }
        if (in_array($b, $circuit)) {
            $circuits[$c][] = $a;
            $found = true;
            break;
        }
    }

    if (!$found) {
        // not added to any circuit?  Add them both to a new circuit
        $circuits[] = [$a, $b];
    }

    // dedupe circuits list
    for ($c = 0; $c < count($circuits)-1; $c++) {
        for ($cc = $c+1; $cc < count($circuits); $cc++) {
            if (count(array_intersect($circuits[$c], $circuits[$cc])) > 0) {
                // a junction appears in both $circuits[$c] AND $circuits[$cc] so we should merge them
                $circuits[$c] = array_unique(array_merge($circuits[$c], $circuits[$cc]));
                array_splice($circuits, $cc, 1);
                break 2;
            }
        }
    }
}

$sizes = array_map(fn (array $circuit) => count($circuit), $circuits);
rsort($sizes);
$top3 = array_slice($sizes, 0, 3);
$answer = array_reduce(
    $top3,
    fn (int $carry, int $num) => $carry * $num,
    1,
);

echo "Answer: $answer\n";
