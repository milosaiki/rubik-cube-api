<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\SideController;
use App\Services\CubeRotationService;
use App\Services\CubeService;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\CubeDataProviderTrait;

class SideControllerTest extends \Tests\TestCase
{
    use CubeDataProviderTrait;

    private SideController|null $sideController;
    private CubeService|MockObject|null $cubeServiceMock;
    private CubeRotationService|MockObject|null $cubeRotationServiceMock;
    private Request|MockObject|null $requestMock;
    private ParameterBag|null|MockObject $parameterBagMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->cubeServiceMock = $this->getMockBuilder(CubeService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->cubeRotationServiceMock = $this->getMockBuilder(CubeRotationService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->requestMock = $this->getMockBuilder(Request::class)
            ->getMock();
        $this->parameterBagMock = $this->getMockBuilder(ParameterBag::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->sideController = new SideController($this->cubeServiceMock, $this->cubeRotationServiceMock);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->cubeServiceMock = null;
        $this->cubeRotationServiceMock = null;
        $this->sideController = null;
        $this->requestMock = null;
        $this->parameterBagMock = null;
    }

    public function testUpdateWhenRotatingRows()
    {
        $cube = $this->getCube();
        $rotatedCube = [
            'front' => [
                ['red', 'red', 'red'],
                ['green', 'green', 'green'],
                ['green', 'green', 'green'],
            ],
            'right' => [
                ['blue', 'blue', 'blue'],
                ['red', 'red', 'red'],
                ['red', 'red', 'red'],
            ],
            'back' => [
                ['orange', 'orange', 'orange'],
                ['blue', 'blue', 'blue'],
                ['blue', 'blue', 'blue'],
            ],
            'left' => [
                ['green', 'green', 'green'],
                ['orange', 'orange', 'orange'],
                ['orange', 'orange', 'orange'],
            ],
            'top' => [
                ['white', 'white', 'white'],
                ['white', 'white', 'white'],
                ['white', 'white', 'white']
            ],
            'bottom' => [
                ['yellow', 'yellow', 'yellow'],
                ['yellow', 'yellow', 'yellow'],
                ['yellow', 'yellow', 'yellow'],
            ]
        ];

        $this->parameterBagMock->expects($this->once())
            ->method('has')
            ->with('row')
            ->willReturn(true);
        $this->parameterBagMock->expects($this->atMost(2))
            ->method('get')
            ->withAnyParameters()
            ->willReturn('top');
        $this->parameterBagMock->expects($this->atMost(2))
            ->method('get')
            ->withAnyParameters()
            ->willReturn('left');
        $this->requestMock->request = $this->parameterBagMock;
        $this->cubeServiceMock->expects($this->once())
            ->method('getCube')
            ->willReturn($cube);
        $this->cubeRotationServiceMock->expects($this->once())
            ->method('rotate')
            ->withAnyParameters()
            ->willReturn($rotatedCube);
        $this->cubeServiceMock->expects($this->once())
            ->method('saveCube')
            ->with($rotatedCube);

        $result = $this->sideController->update($this->requestMock, 1);
    }

    public function testUpdateWhenRotatingColumns()
    {
        $cube = $this->getCube();
        $rotatedCube = [
            'front' => [
                ['green', 'green', 'yellow'],
                ['green', 'green', 'yellow'],
                ['green', 'green', 'yellow']
            ],
            'right' => [
                ['red', 'red', 'red'],
                ['red', 'red', 'red'],
                ['red', 'red', 'red']
            ],
            'back' => [
                ['blue', 'blue', 'white'],
                ['blue', 'blue', 'white'],
                ['blue', 'blue', 'white'],
            ],
            'left' => [
                ['orange', 'orange', 'orange'],
                ['orange', 'orange', 'orange'],
                ['orange', 'orange', 'orange']
            ],
            'top' => [
                ['white', 'white', 'green'],
                ['white', 'white', 'green'],
                ['white', 'white', 'green']
            ],
            'bottom' => [
                ['yellow', 'yellow', 'blue'],
                ['yellow', 'yellow', 'blue'],
                ['yellow', 'yellow', 'blue']
            ]
        ];

        $this->parameterBagMock->expects($this->once())
            ->method('has')
            ->with('row')
            ->willReturn(false);
        $this->parameterBagMock->expects($this->atMost(2))
            ->method('get')
            ->withAnyParameters()
            ->willReturn('left');
        $this->parameterBagMock->expects($this->atMost(2))
            ->method('get')
            ->withAnyParameters()
            ->willReturn('top');
        $this->requestMock->request = $this->parameterBagMock;
        $this->cubeServiceMock->expects($this->once())
            ->method('getCube')
            ->willReturn($cube);
        $this->cubeRotationServiceMock->expects($this->once())
            ->method('rotate')
            ->withAnyParameters()
            ->willReturn($rotatedCube);
        $this->cubeServiceMock->expects($this->once())
            ->method('saveCube')
            ->with($rotatedCube);

        $result = $this->sideController->update($this->requestMock, 1);
    }
}
