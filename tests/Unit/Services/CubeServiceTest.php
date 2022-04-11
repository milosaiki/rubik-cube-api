<?php

namespace Tests\Unit\Services;

use App\Repository\CubeRepository;
use App\Services\CubeRotationService;
use App\Services\CubeService;
use App\Services\CubeServiceInterface;
use App\Services\RotationService;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\CubeDataProviderTrait;
use Tests\TestCase;

class CubeServiceTest extends TestCase
{

    use CubeDataProviderTrait;

    private CubeRepository|MockObject|null $cubeRepositoryMock;
    private CubeServiceInterface|null $cubeService;
    private RotationService|MockObject|null $rotationServiceMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->cubeRepositoryMock = $this->getMockBuilder(CubeRepository::class)
            ->getMock();
        $this->rotationServiceMock = $this->getMockBuilder(RotationService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->cubeService = new CubeService(
            $this->cubeRepositoryMock,
            $this->rotationServiceMock
        );
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->cubeRepositoryMock = null;
        $this->cubeService = null;
        $this->rotationServiceMock = null;
    }

    public function testGetCube()
    {
        $cube = $this->getCube();
        $this->cubeRepositoryMock->expects($this->once())
            ->method('get')
            ->willReturn($cube);
        $result = $this->cubeService->getCube();

        $this->assertSame($cube, $result);
    }

    /**
     * @dataProvider cubeDataProvider
     */
    public function testSaveCube(array $cube): void
    {
        $this->cubeRepositoryMock->expects($this->once())
            ->method('save');

        $this->cubeService->saveCube($cube);
    }

    /**
     * @dataProvider rotateCubeDataProvider
     */
    public function testRotateCube(array $cube, string $direction, string $row)
    {
        $rotated = [
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

        $this->cubeRepositoryMock->expects($this->once())
            ->method('get')
            ->willReturn($cube);
        $this->rotationServiceMock->expects($this->once())
            ->method('rotate')
            ->with($cube, $direction, $row)
            ->willReturn($rotated);
        $this->cubeRepositoryMock->expects($this->once())
            ->method('save');

        $this->cubeService->rotateCube($direction, $row);
    }

    public function cubeDataProvider(): array
    {
        return [
            [$this->getCube()]
        ];
    }

    public function rotateCubeDataProvider()
    {
        return [
            [$this->getCube(), 'up', 'right']
        ];
    }
}
