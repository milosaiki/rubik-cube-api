<?php

namespace App\Services;

use App\Helpers\Row;
use App\Services\RotationServiceInterface;
use App\Traits\RotateAdjacentSideTrait;
use App\Traits\RotateLeftTrait;
use App\Traits\RotateRightTrait;

class HorizontalRotationService implements RotationServiceInterface
{
    use RotateLeftTrait, RotateRightTrait, RotateAdjacentSideTrait;

    private const SIDES = ['front', 'right', 'back', 'left'];
    private const ROW_TO_INDEX_MAPPER = [
        'top' => 0,
        'middle' => 1,
        'bottom' => 2
    ];
    private const DIRECTION_LEFT = 'left';

    private function flatten(array $cube, int $row): array
    {
        $data = [];

        foreach (self::SIDES as $sideName) {
            $item = array_values($cube[$sideName][$row]);

            foreach ($item as $value) {
                $data[] = $value;
            }
        }

        return $data;
    }


    public function rotate(array $cube, string $direction, string $rotationEl): array
    {
        $index = self::ROW_TO_INDEX_MAPPER[$rotationEl];
        $data = $this->flatten($cube, $index);
        $rotatedRow = $this->rotateRow($data, $direction);
        $newRow = $this->getNewRowData($rotatedRow);

        $cube = $this->replaceOldValuesWithNew($cube, $newRow, $index);

        if (!$this->isMiddleRowMoved($rotationEl)) {
            $rotateMethod = 'rotateSideCounterClockWise';

            if ($this->isDirectionToLeft($direction)) {
                $rotateMethod = 'rotateSideClockWise';
            }

            $cube[$rotationEl] = $this->$rotateMethod($cube[$rotationEl]);
        }

        return $cube;
    }

    private function rotateRow(array $data, string $direction): array
    {
        return  $this->isDirectionToLeft($direction)? $this->rotateToLeft($data) : $this->rotateToRight($data);
    }

    private function isDirectionToLeft(string $direction): bool
    {
        return self::DIRECTION_LEFT === $direction;
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

    private function replaceOldValuesWithNew(array $cube, array $newRow, int $index): array
    {
        foreach ($cube as $key => $side) {
            if (array_key_exists($key, $newRow)) {
                $cube[$key][$index] = $newRow[$key];
            }
        }

        return $cube;
    }

    private function isMiddleRowMoved(string $row): bool
    {
        return Row::MIDDLE === $row;
    }
}
