<?php

namespace Tests\Unit\Services;

use App\Repository\CubeRepository;
use App\Services\CubeRotationService;
use App\Services\CubeService;
use App\Services\CubeServiceInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\CubeDataProviderTrait;
use Tests\TestCase;

class CubeServiceTest extends TestCase
{

    use CubeDataProviderTrait;

    private CubeRepository|MockObject|null $cubeRepositoryMock;
    private CubeServiceInterface|null $cubeService;

    public function setUp(): void
    {
        parent::setUp();
        $this->cubeRepositoryMock = $this->getMockBuilder(CubeRepository::class)
            ->getMock();
        $this->cubeService = new CubeService(
            $this->cubeRepositoryMock
        );
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->cubeRepositoryMock = null;
        $this->cubeService = null;
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

    public function cubeDataProvider(): array
    {
        return [
            [$this->getCube()]
        ];
    }
}
