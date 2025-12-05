<?php

$input = file_get_contents(__DIR__ . '/real-input');
[$ingredientRanges, $ingredients] = explode("\n\n", $input, 2);
$ingredientRanges = explode("\n", trim($ingredientRanges));
$ingredients = array_map(
    intval(...),
    explode("\n", trim($ingredients)),
);

$ans = 0;

foreach ($ingredients as $ingredient) {
    // check if the ingredient is in any range in the ingredientsRange
    foreach ($ingredientRanges as $ingredientRange) {
        [$start, $end] = array_map(
            intval(...),
            explode("-", trim($ingredientRange)),
        );

        if ($start <= $ingredient && $end >= $ingredient) {
            $ans++;
            break;
        }
    }
}

echo "Answer: $ans\n";
