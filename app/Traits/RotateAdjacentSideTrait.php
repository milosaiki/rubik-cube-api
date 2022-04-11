<?php

namespace App\Traits;

trait RotateAdjacentSideTrait
{
    private function rotateSideClockWise(array $data): array
    {
        if (empty($data)) {
            return $data;
        }

        $data = $this->reverseColumns($data);

        return $this->transpose($data);
    }

    private function rotateSideCounterClockWise(array $data): array
    {
        array_unshift($data, null);
        $data = array_map(...$data);

        return array_map('array_reverse', $data);
    }

    private function reverseColumns(array $data): array
    {
        $numOfColumns = count($data[0]);

        for ($i = 0; $i < $numOfColumns; $i++) {
            for ($j = 0, $k = $numOfColumns - 1; $j < $k; $j++, $k--) {
                $t = $data[$j][$i];
                $data[$j][$i] = $data[$k][$i];
                $data[$k][$i] = $t;
            }
        }

        return $data;
    }

    private function transpose(array $data): array
    {
        $numOfRows = count($data);
        $numOfColumns = count($data[0]);

        for ($i = 0; $i < $numOfRows; $i++) {
            for ($j = $i; $j < $numOfColumns; $j++) {
                $t = $data[$i][$j];
                $data[$i][$j] = $data[$j][$i];
                $data[$j][$i] = $t;
            }
        }

        return $data;
    }
}
