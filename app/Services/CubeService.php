<?php

namespace App\Services;

use App\Helpers\Cube;
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

    public function rotateCube(string $direction, $row, int $id): void
    {
        $cube = $this->getRebasedCube($id);
        $newCube = $this->rotationService->rotate($cube, $direction, $row);
        $this->saveCube($newCube);
    }

    private function getRebasedCube(int $id): array
    {
        $order = Cube::HORIZONTAL_SIDE_ORDER;
        $sideNameOrder = Cube::HORIZONTAL_SIDE_NAME_ORDER;

        if ($this->isVerticalSideRotated($id)) {
            $order = Cube::VERTICAL_SIDE_ORDER;
            $sideNameOrder = Cube::VERTICAL_SIDE_NAME_ORDER;
        }

        $reorderedSides = $this->getReorderedArray($id, $order);

        return $this->getRotatedCube($reorderedSides, $sideNameOrder);
    }

    private function isVerticalSideRotated(int $id): bool
    {
        return in_array($id, Cube::VERTICAL_SIDES);
    }

    /**
     * reorder cube row/column based on rotated side
     * $id of the passed side will always be front one and the rest of the sides will be rebased accordingly
     */
    private function getReorderedArray(int $id, array $order): array
    {
        $index = array_search($id, $order);
        $restOfTheOrder = array_splice($order, $index);
        $firstPart = array_splice($order, 0, $index);

        return array_merge($restOfTheOrder, $firstPart);
    }

    private function getRotatedCube(array $reorderedSides, array $sideNameOrder): array
    {
        $rotated = [];
        $cube = $this->getCube();

        foreach ($reorderedSides as $index => $value) {
            $rotatedSide = Cube::SIDE_ID_MAPPER[$value];
            $side = $sideNameOrder[$index];
            $rotated[$side] = $cube[$rotatedSide];
        }

        return array_merge($cube, $rotated);
    }
}
