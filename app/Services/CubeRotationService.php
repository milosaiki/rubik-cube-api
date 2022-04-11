<?php

namespace App\Services;

use App\Transformers\CubeTransformerInterface;

class CubeRotationService implements CubeRotationServiceInterface
{
    private CubeTransformerInterface $cubeTransformer;

    public function __construct(CubeTransformerInterface $cubeTransformer)
    {
        $this->cubeTransformer = $cubeTransformer;
    }

    public function rotate(array $cube, string $direction, string $rotationEl): array
    {
        return $this->cubeTransformer->rotate($cube, $direction, $rotationEl);
    }
}
