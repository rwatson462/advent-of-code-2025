<?php

# Make 10 shortest connections with example data
# Make 1000 shortest connections with real data

$input = array_map(
    trim(...),
    file(__DIR__ . '/example-input'),
);

function dist(int $x, int $y, int $z): float
{
    return $x * $x + $y * $y + $z * $z;
}

$distances = [];
for ($i = 0; $i < count($input); $i++) {
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

// build circuits using the closest boxes that aren't already in a circuit
$circuits = [];
# todo change to 1000 for real input
$connections = 0;

foreach ($distances as $next => $_) {
    if ($connections++ === 11) {
        break;
    }

    [$a, $b] = explode('-', $next);
//    echo "Checking $a >> $b\n";

    foreach ($circuits as $circuit) {
        if (in_array($a, $circuit) && in_array($b, $circuit)) {
            // we have already added both of these to the same circuit
//            echo "In same circuit: $a >> $b\n";
            continue 2;
        }
    }

    // if not, attach to a circuit
    for ($c = 0; $c < count($circuits); $c++) {
        $circuit = $circuits[$c];
        if (in_array($a, $circuit)) {
            $circuits[$c][] = $b;
//            echo "A already in circuit, adding B\n";
            continue 2;
        }
        if (in_array($b, $circuit)) {
            $circuits[$c][] = $a;
//            echo "B already in circuit, adding A\n";
            continue 2;
        }
    }

    // not added to any circuit?  Add them both to a new circuit
//    echo "Neither already in a circuit\n";
    $circuits[] = [$a,$b];
}

var_dump($circuits);
