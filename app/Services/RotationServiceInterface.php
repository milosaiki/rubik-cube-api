<?php

namespace App\Services;

interface RotationServiceInterface
{
    public function rotate(array $cube, string $direction, string $rotationEl): array;
}
