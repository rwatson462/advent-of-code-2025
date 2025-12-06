<?php

$input = array_map(
    fn (string $line) => rtrim($line, "\n"),
    file(__DIR__ . '/real-input'),
);

$done = false;
$newInput = [];
while (!$done) {
    $max = 0;
    foreach ($input as $line) {
        $max = max($max, strpos($line, " "));
    }

    if ($max === 0) $max = null;

    $col = [];
    foreach ($input as &$line) {
        $col[] = substr($line, 0, $max);
        $line = substr($line, $max+1);
    }
    unset($line);

    $newInput[] = $col;

    if ($max === null) {
        $done = true;
    }
}

$ans = 0;

for ($i = 0; $i < count($newInput); $i++) {
    $problem = $newInput[$i];
    $operator = trim(array_pop($problem));

    // transform the problem into weird column right-to-left thing
    $problem = array_map(
        fn (string $line) => str_split($line),
        $problem,
    );

    $max = array_reduce(
        $problem,
        fn (int $carry, array $input) => max($carry, count($input)),
    0,
    );

    $numbers = [];
    for($j = 0; $j < $max; $j++) {
        $col = array_column($problem, $j);
        $numbers[] = (int)str_replace(' ', '', implode('', $col));
    }

    $initial = array_shift($numbers);

    $solution = match($operator) {
        "+" => array_reduce(
            $numbers,
            fn ($carry, $item) => $carry + (int) $item,
            $initial,
        ),
        "*" => array_reduce(
            $numbers,
            fn ($carry, $item) => $carry * (int) $item,
            $initial,
        )
    };

    $ans += $solution;
}

echo "Answer: $ans\n";
