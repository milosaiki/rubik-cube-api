<?php

namespace App\Services;

use App\Repository\CubeRepositoryInterface;
use JetBrains\PhpStorm\ArrayShape;

class CubeService implements CubeServiceInterface
{
    private CubeRepositoryInterface $cubeRepository;

    public function __construct(CubeRepositoryInterface $cubeRepository)
    {
        $this->cubeRepository = $cubeRepository;
    }

    #[ArrayShape(
        [
            'front' => "array",
            'back' => "array",
            'left' => "array",
            'right' => "array",
            'top' => "array",
            'bottom' => "array"
        ]
    )]
    public function getCube(): array
    {
        return $this->cubeRepository->get();
    }

    public function saveCube(array $cube): void
    {
        $this->cubeRepository->save($cube);
    }
}
