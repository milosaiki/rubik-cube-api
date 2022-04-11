<?php

namespace App\Traits;

trait RotateLeftTrait
{
    private function rotateToLeft(array $data): array
    {
        $rotatedEl = array_slice($data, 0, 3);
        $reducedArray = array_splice($data, 3);

        return array_merge($reducedArray, $rotatedEl);
    }
}
