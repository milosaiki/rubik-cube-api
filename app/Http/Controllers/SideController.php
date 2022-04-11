<?php

namespace App\Http\Controllers;

use App\Services\CubeService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SideController extends Controller
{
    private CubeService $cubeService;

    public function __construct(CubeService $cubeService)
    {
        $this->cubeService = $cubeService;
    }

    /**
     * TODO: implement cube rotation based on $id passed
     * @param $id - represent cube side, center cube so the side that is updating is always front one
     */
    public function update(Request $request, int $id): Response
    {
        $row = $request->request->has('row') ?
            $request->request->get('row') :
            $request->request->get('column');
        $direction = $request->request->get('direction');
        $this->cubeService->rotateCube($direction, $row);

        return response()->noContent();
    }
}
