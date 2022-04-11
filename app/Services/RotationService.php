<?php

namespace App\Services;

use App\Helpers\Direction;

class RotationService implements RotationServiceInterface
{
    private HorizontalRotationService $horizontalRotationService;
    private VerticalRotationService $verticalRotationService;

    public function __construct(
        HorizontalRotationService $horizontalRotationService,
        VerticalRotationService $verticalRotationService
    ) {
        $this->horizontalRotationService = $horizontalRotationService;
        $this->verticalRotationService = $verticalRotationService;
    }

    public function rotate(array $cube, string $direction, string $rotationEl): array
    {
        return $this->isHorizontalDirection($direction) ?
            $this->horizontalRotationService->rotate($cube, $direction, $rotationEl) :
            $this->verticalRotationService->rotate($cube, $direction, $rotationEl);
    }

    private function isHorizontalDirection(string $direction): bool
    {
        return in_array($direction, Direction::HORIZONTAL);
    }
}
