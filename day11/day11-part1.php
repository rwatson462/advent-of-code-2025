<?php

$filename  = __DIR__.'/real-input';

$input = array_map(
    fn (string $line) => explode(' ', trim($line)),
    file($filename),
);

class Node {
    public function __construct(
        public string $value,
        /** @var array<Node>  */
        public array $neighbours = [],
    ) {}
}

/** @var array<Node> $nodes */
$nodes = [];

function add(array &$nodes, string $parent, string $value): void {
    // search the list of nodes for the parent
    // if we don't find the parent, create it
    $node = array_find($nodes, fn($node) => $node->value === $parent);
    if (is_null($node)) {
        $node = new Node($parent);
        $nodes[] = $node;
    }

    // search the nodes for the value
    $neighbour = array_find($nodes, fn($node) => $node->value === $value);
    // if we don't find it, create it
    if (is_null($neighbour)) {
        $neighbour = new Node($value);
        $nodes[] = $neighbour;
    }

    // attach the value to the parent as a neighbour
    $node->neighbours[] = $neighbour;
}

function countValues(Node $node): int {
    if ($node->value === 'out') {
        return 1;
    }

    $counter = 0;
    foreach ($node->neighbours as $neighbour) {
        $counter += countValues($neighbour);
    }

    return $counter;
}

// build a tree for all paths
foreach ($input as $devices) {
    $in = trim(array_shift($devices), ':');

    foreach($devices as $out) {
        add($nodes, $in, $out);
    }
}

// now we search from $start to find every "out"
$start = array_find($nodes, fn($node) => $node->value === 'you');
$answer = countValues($start);

echo "Answer: $answer\n";
