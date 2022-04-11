<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\CubeController;
use App\Services\CubeService;
use Illuminate\Http\JsonResponse;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\CubeDataProviderTrait;

class CubeControllerTest extends \Tests\TestCase
{
    use CubeDataProviderTrait;

    private CubeService|MockObject|null $cubeServiceMock;
    private CubeController|null $cubeController;

    public function setUp(): void
    {
        parent::setUp();
        $this->cubeServiceMock = $this->getMockBuilder(CubeService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->cubeController = new CubeController($this->cubeServiceMock);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->cubeServiceMock = null;
        $this->cubeController = null;
    }

    public function testIndex()
    {
        $cube = $this->getCube();
        $this->cubeServiceMock->expects($this->once())
            ->method('getCube')
            ->willReturn($cube);
        $result = $this->cubeController->index();
        $decodedResult = json_decode($result->getContent(), true);

        $this->assertSame($cube, $decodedResult);
    }
}
