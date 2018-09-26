<?php

function clearScreen($size): void
{
// Erasure MAGIC: Clear as many lines as the last output had.
    for ($i = 0; $i < $size; $i++) {
        // Return to the beginning of the line
        echo "\r";
        // Erase to the end of the line
        echo "\033[K";
        // Move cursor Up a line
        echo "\033[1A";
        // Return to the beginning of the line
        echo "\r";
        // Erase to the end of the line
        echo "\033[K";
        // Return to the beginning of the line
        echo "\r";
        // Can be consolodated into
        // echo "\r\033[K\033[1A\r\033[K\r";
    }
}

function printGrid($grid, $size): void
{
    clearScreen($size);

    foreach ($grid as $y => $row) {
        foreach ($row as $x => $value) {
            echo $value." ";
        }
        echo "\n";
    }
}

function addGlider($grid)
{
    $grid[0][0] = '-';
    $grid[0][1] = '-';
    $grid[0][2] = 'X';
    $grid[0][3] = '-';
    $grid[0][4] = '-';

    $grid[1][0] = 'X';
    $grid[1][1] = '-';
    $grid[1][2] = 'X';
    $grid[1][3] = '-';
    $grid[1][4] = '-';

    $grid[2][0] = '-';
    $grid[2][1] = 'X';
    $grid[2][2] = 'X';
    $grid[2][3] = '-';
    $grid[2][4] = '-';

    return $grid;
}

function initializeGrid($size)
{
    for ($q = 0; $q < $size; $q++) {
        for ($r = 0; $r < $size; $r++) {
            $grid[$q][$r] = '-';
        }
    }

    return $grid;
}

function executeLifeCycle($grid): array
{
    foreach ($grid as $y => $row) {
        foreach ($row as $x => $value) {

            $liveCellCount = 0;

            for ($vert = -1; $vert < 2; $vert++) {
                for ($horiz = -1; $horiz < 2; $horiz++) {
                    if ($vert == 0 && $horiz == 0) {
                        continue;
                    }
                    $liveCellCount += ((isset($grid[$y + $vert][$x + $horiz]) && ($grid[$y + $vert][$x + $horiz] == 'X')) ? 1 : 0);
                }
            }

            if ($grid[$y][$x]) {
                if (($liveCellCount == 3) || ($liveCellCount == 2 && $value == 'X')) {
                    // cell stays alive
                    $newState[$y][$x] = 'X';
                } else {
                    // cell dies
                    $newState[$y][$x] = '-';
                }
            } else {
                if ($liveCellCount == 3) {
                    // new cell born
                    $newState[$y][$x] = 'X';
                } else {
                    // no cell
                    $newState[$y][$x] = '-';
                }

            }
        }
    }

    return $newState;
}

// Main program
$size = 50;
$lifeCycles = 300;

$grid = initializeGrid($size);

for ($z = 0; $z < $lifeCycles; $z++) {
    printGrid($grid, $size);

    if (0 == ($z % 14)) {
        $grid = addGlider($grid);
    }

    $grid = executeLifeCycle($grid);

    usleep(50000);
}
