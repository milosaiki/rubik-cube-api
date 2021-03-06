<?php

namespace App\Services;

use App\Helpers\Column;
use App\Helpers\Direction;
use App\Services\RotationServiceInterface;
use App\Traits\RotateAdjacentSideTrait;
use App\Traits\RotateLeftTrait;
use App\Traits\RotateRightTrait;

class VerticalRotationService implements RotationServiceInterface
{
    use RotateLeftTrait, RotateRightTrait, RotateAdjacentSideTrait;

    private const SIDES = ['front', 'top', 'back', 'bottom'];
    private const COLUMN_TO_INDEX_MAPPER = [
        'left' => 0,
        'middle' => 1,
        'right' => 2
    ];
    private const ROTATE_METHOD = [
        'clockwise' => 'rotateSideClockWise',
        'counterClockwise' => 'rotateSideCounterClockWise'
    ];

    public function rotate(array $cube, string $direction, string $rotationEl): array
    {
        $index = self::COLUMN_TO_INDEX_MAPPER[$rotationEl];
        $data = $this->flatten($cube, $index);
        $rotatedData = $this->rotateData($data, $direction);
        $newRow = $this->getNewRowData($rotatedData);
        $cube = $this->replaceOldValuesWithNew($cube, $newRow, $index);

        if (!$this->isMiddleColumnMoved($rotationEl)) {
            $rotateMethod = self::ROTATE_METHOD['counterClockwise'];

            if ($this->isDirectionUp($direction)) {
                $rotateMethod = self::ROTATE_METHOD['clockwise'];
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
        return Direction::UP === $direction;
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
        return Column::middle->name === $rotationEl;
    }
}
