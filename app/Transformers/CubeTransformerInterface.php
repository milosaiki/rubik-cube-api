<?php

namespace App\Transformers;

interface CubeTransformerInterface
{
    public function rotate(array $cube, string $direction, string $rotationEl): array;
}
