<?php

$input = array_map(
    function (string $line) {
        $line = trim($line);

        $pieces = explode(" ", $line);

        $lightDiagram = trim(array_shift($pieces), '[]');
        $joltageRequirements = trim(array_pop($pieces), '{}');
        $wiringSchematics = array_map(
            fn (string $in) => explode(',',trim($in, '()')),
            array: $pieces,
        );

        return [
            $lightDiagram,
            $wiringSchematics,
            // part 1 doesn't use these
            // $joltageRequirements,
        ];
    },
    file(__DIR__ . '/real-input'),
);

function applyButton(string $in, array $button): string {
    foreach ($button as $butt) {
        $in[$butt] = $in[$butt] === '#'
            ? '.'
            : '#';
    }

    return $in;
}

function solve(int $count, string $lights, string $targetLights, array $buttons, int $buttonId): int|false {
    if ($count > 10) return false;

    $button = $buttons[$buttonId];

    $lights = applyButton($lights, $button);
    if ($lights === $targetLights) {
        return $count;
    }

    $lowest = PHP_INT_MAX;
    foreach($buttons as $id => $_) {
        if ($id === $buttonId) {
            continue;
        }

        $min = solve($count+1, $lights, $targetLights, $buttons, $id);
        if ($min !== false) {
            $lowest = min($lowest, $min);
        }
    }

    return $lowest;
}

$answer = 0;

foreach ($input as $line) {
    $lights = str_repeat('.', strlen($line[0]));

    $targetLights = $line[0];
    $buttons = $line[1];

    $lowest = PHP_INT_MAX;
    foreach ($buttons as $id => $_) {
        $count = solve(1, $lights, $targetLights, $buttons, $id);
        if ($count !== false) {
            $lowest = min($lowest, $count);
        }
    }

    echo "Solved in: $lowest\n";
    $answer += $lowest;
}

echo "Answer: $answer\n";
