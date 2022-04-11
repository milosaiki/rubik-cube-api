<?php

namespace App\Transformers;

class CubeTransformer implements CubeTransformerInterface
{
    private const HORIZONTAL_DIRECTION = ['left', 'right'];
    private HorizontalTransformer $horizontalTransformer;
    private VerticalTransformer $verticalTransformer;

    public function __construct(HorizontalTransformer $horizontalTransformer, VerticalTransformer $verticalTransformer)
    {
        $this->horizontalTransformer = $horizontalTransformer;
        $this->verticalTransformer = $verticalTransformer;
    }

    public function rotate(array $cube, string $direction, string $rotationEl): array
    {
        return $this->isHorizontalDirection($direction) ?
            $this->horizontalTransformer->rotate($cube, $direction, $rotationEl) :
            $this->verticalTransformer->rotate($cube, $direction, $rotationEl);
    }

    private function isHorizontalDirection(string $direction): bool
    {
        return in_array($direction, self::HORIZONTAL_DIRECTION);
    }
}
