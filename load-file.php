<?php

function loadFile(string $filename): array {
    return array_map(
        callback: trim(...),
        array: explode("\n", file_get_contents($filename)),
    );
}
