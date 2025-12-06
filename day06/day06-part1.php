<?php

$input = array_map(
    fn (string $line) => preg_split('/\s+/', trim($line)),
    file(__DIR__ . '/real-input'),
);

$ans = 0;

for ($i = 0; $i < count($input[0]); $i++) {
    $problem = array_column($input, $i);
    $operator = array_pop($problem);

    $initial = (int) array_shift($problem);

    $solution = match($operator) {
        "+" => array_reduce(
            $problem,
            fn ($carry, $item) => $carry + (int) $item,
            $initial,
        ),
        "*" => array_reduce(
            $problem,
            fn ($carry, $item) => $carry * (int) $item,
            $initial,
        )
    };

    $ans += $solution;
}

echo "Answer: $ans\n";
