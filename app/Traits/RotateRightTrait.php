<?php

namespace App\Traits;

trait RotateRightTrait
{
    private function rotateToRight(array $data): array
    {
        $rotatedEl = array_slice($data, count($data) - 3, 3);
        $reducedArray = array_splice($data, 0, count($data) - 3);

        return array_merge($rotatedEl, $reducedArray);
    }
}
