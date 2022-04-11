<?php

namespace App\Services;

interface CubeRotationServiceInterface
{
    public function rotate(array $cube, string $direction, string $rotationEl): array;
}
