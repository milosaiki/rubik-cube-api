<?php

namespace App\Transformers;

use App\Traits\RotateAdjacentSideTrait;
use App\Traits\RotateLeftTrait;
use App\Traits\RotateRightTrait;

class VerticalTransformer implements CubeTransformerInterface
{
    use RotateLeftTrait, RotateRightTrait, RotateAdjacentSideTrait;

    private const SIDES = ['front', 'top', 'back', 'bottom'];
    private const COLUMN_TO_INDEX_MAPPER = [
        'left' => 0,
        'middle' => 1,
        'right' => 2
    ];
    private const DIRECTION_UP = 'up';

    public function rotate(array $cube, string $direction, string $rotationEl): array
    {
        $index = self::COLUMN_TO_INDEX_MAPPER[$rotationEl];
        $data = $this->flatten($cube, $index);
        $rotatedData = $this->rotateData($data, $direction);
        $newRow = $this->getNewRowData($rotatedData);
        $cube = $this->replaceOldValuesWithNew($cube, $newRow, $index);

        if (!$this->isMiddleColumnMoved($rotationEl)) {
            $rotateMethod = 'rotateSideCounterClockWise';

            if ($this->isDirectionUp($direction)) {
                $rotateMethod = 'rotateSideClockWise';
            }

            $cube[$rotationEl] = $this->$rotateMethod($cube[$rotationEl]);
        }

        return $cube;
    }

    private function flatten($cube, $index): array
    {
        $data = [];

        foreach (self::SIDES as $side) {
            foreach ($cube[$side] as $item) {
                $data[] = $item[$index];
            }
        }

        return $data;
    }

    private function rotateData(array $data, string $direction): array
    {
        return $this->isDirectionUp($direction) ? $this->rotateToRight($data) : $this->rotateToLeft($data);
    }

    private function isDirectionUp(string $direction): bool
    {
        return self::DIRECTION_UP === $direction;
    }

    private function replaceOldValuesWithNew(array $cube, array $newRow, int $index): array
    {
        foreach ($cube as $key => $side) {
            if (array_key_exists($key, $newRow)) {
                $counter = 0;

                foreach ($side as $sideIndex => $row) {
                    $cube[$key][$sideIndex][$index] = $newRow[$key][$counter];
                    $counter++;
                }
            }
        }

        return $cube;
    }

    private function getNewRowData(array $rotatedData): array
    {
        $newRow = array_flip(self::SIDES);
        $chunkedData = array_chunk($rotatedData, 3);

        foreach ($newRow as $key => $value) {
            $newRow[$key] = $chunkedData[$value];
        }

        return $newRow;
    }

    private function isMiddleColumnMoved(string $rotationEl): bool
    {
        return 'middle' === $rotationEl;
    }
}
