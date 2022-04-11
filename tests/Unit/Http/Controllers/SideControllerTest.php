<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\SideController;
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
    private Request|MockObject|null $requestMock;
    private ParameterBag|null|MockObject $parameterBagMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->cubeServiceMock = $this->getMockBuilder(CubeService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['rotateCube'])
            ->getMock();
        $this->requestMock = $this->getMockBuilder(Request::class)
            ->getMock();
        $this->parameterBagMock = $this->getMockBuilder(ParameterBag::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->sideController = new SideController($this->cubeServiceMock);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->cubeServiceMock = null;
        $this->sideController = null;
        $this->requestMock = null;
        $this->parameterBagMock = null;
    }

    public function testUpdateWhenRotatingRows()
    {
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
            ->method('rotateCube')
            ->withAnyParameters();


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
            ->method('rotateCube')
            ->withAnyParameters();

        $result = $this->sideController->update($this->requestMock, 1);
    }
}
