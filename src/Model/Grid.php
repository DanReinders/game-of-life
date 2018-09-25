<?php

namespace App\Model;

class Grid
{
    protected $grid;

    public function __construct($size = 10)
    {
        $grid = [];
        for ($q = 0; $q < $size; $q++) {
            for ($r = 0; $r < $size; $r++) {
                $grid[$q][$r] = '-';
            }
        }

        $this->grid = $grid;
    }

    public function setGrid(array $grid): void
    {
        $this->grid = $grid;
    }

    public function getGrid(): array
    {
        return $this->grid;
    }

    public function toString(): string
    {
        $string = null;
        foreach ($this->grid as $row => $columns) {
            $string .= implode('', $columns).'<br />';
        }

        return $string;
    }

    public function addGlider(): void
    {
        $this->grid[0][2] = 'X';

        $this->grid[1][0] = 'X';
        $this->grid[1][2] = 'X';

        $this->grid[2][1] = 'X';
        $this->grid[2][2] = 'X';
    }

    public function executeLifeCycle(): void
    {
        $grid = $this->grid;
        foreach ($grid as $y => $row) {
            foreach ($row as $x => $value) {

                $liveCellCount = 0;

                for ($vert = -1; $vert < 2; $vert++) {
                    for ($horiz = -1; $horiz < 2; $horiz++) {
                        if ($vert == 0 && $horiz == 0) {
                            continue;
                        }

                        $liveCellCount += (isset($grid[$y + $vert][$x + $horiz]) && ($grid[$y + $vert][$x + $horiz] == 'X')) ? 1 : 0;
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

        $this->grid = $newState;
    }

}
