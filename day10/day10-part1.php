<?php

$filename = __DIR__ . '/real-input';

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
    file($filename),
);

function applyButton(string $in, array $button): string {
    foreach ($button as $butt) {
        $in[$butt] = $in[$butt] === '#'
            ? '.'
            : '#';
    }

    return $in;
}

function solve(string $lights, string $targetLights, array $node, int $depth = 0): int|false {
    if (isset($node['value'])) {
        $lights = applyButton($lights, $node['value']);
    }

    if ($lights === $targetLights) {
        return $depth;
    }

    if (!isset($node['children'])) {
        return false;
    }

    $lowest = PHP_INT_MAX;
    foreach($node['children'] as $child) {
        $lowest = min(
            $lowest,
            solve($lights, $targetLights, $child, $depth + 1) ?: PHP_INT_MAX
        );
    }

    return $lowest;
}

function tree(array &$node, array $items): void {
    // initialise children array key
    if (count($items) > 0 && ! isset($node['children'])) $node['children'] = [];

    $new = [...$items];
    while (($item = array_shift($new)) !== null) {
        $next = [
            'value' => $item,
        ];
        tree($next, $new);
        $node['children'][] = $next;
    }
}

$answer = 0;

foreach ($input as $line) {
    $lights = str_repeat('.', strlen($line[0]));

    $targetLights = $line[0];
    $buttons = $line[1];

    $root = [];
    tree($root, $buttons);

    // traverse the tree to find the correct set of buttons to press
    $solution = solve($lights, $targetLights, $root);

    $answer += $solution;
}

echo "Answer: $answer\n";
