<?php

namespace App\Http\Controllers;

use App\Services\CubeServiceInterface;
use App\Traits\RotateAdjacentSideTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CubeController extends Controller
{
    use RotateAdjacentSideTrait;

    private CubeServiceInterface $cubeService;

    public function __construct(CubeServiceInterface $cubeService)
    {
        $this->cubeService = $cubeService;
    }

    public function index(): JsonResponse
    {
        $cube = $this->cubeService->getCube();

        return response()->json($cube);
    }
}
