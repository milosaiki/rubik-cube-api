<?php

namespace App\Http\Controllers;

use App\Services\CubeRotationServiceInterface;
use App\Services\CubeService;
use App\Transformers\CubeTransformerInterface;
use App\Transformers\HorizontalTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SideController extends Controller
{
    private CubeService $cubeService;
    private CubeRotationServiceInterface $cubeRotationService;

    public function __construct(CubeService $cubeService, CubeRotationServiceInterface $cubeRotationService)
    {
        $this->cubeService = $cubeService;
        $this->cubeRotationService = $cubeRotationService;
    }

    /**
     * TODO: implement cube rotation based on $id passed
     * @param $id - represent cube side, center cube so the side that is updating is always front one
     * @throws \Exception
     */
    public function update(Request $request, int $id): Response
    {
        $row = $request->request->has('row') ?
            $request->request->get('row') :
            $request->request->get('column');
        $direction = $request->request->get('direction');
        $cube = $this->cubeService->getCube();
        $newCube = $this->cubeRotationService->rotate($cube, $direction, $row);
        $this->cubeService->saveCube($newCube);

        return response()->noContent();
    }
}
