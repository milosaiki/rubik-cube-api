<?php

namespace App\Services;

use App\Repository\CubeRepositoryInterface;
use App\Traits\RotateTrait;

class CubeService implements CubeServiceInterface
{

    private CubeRepositoryInterface $cubeRepository;
    private RotationServiceInterface $rotationService;

    public function __construct(CubeRepositoryInterface $cubeRepository, RotationServiceInterface $rotationService)
    {
        $this->cubeRepository = $cubeRepository;
        $this->rotationService = $rotationService;
    }

    public function getCube(): array
    {
        return $this->cubeRepository->get();
    }

    public function saveCube(array $cube): void
    {
        $this->cubeRepository->save($cube);
    }

    public function rotateCube(string $direction, $row): void
    {
        $cube = $this->getCube();
        $newCube = $this->rotationService->rotate($cube, $direction, $row);
        $this->saveCube($newCube);
    }
}
