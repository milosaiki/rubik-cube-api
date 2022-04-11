<?php

namespace App\Services;

interface CubeServiceInterface
{
    public function getCube(): array;
    public function saveCube(array $cube): void;
}
