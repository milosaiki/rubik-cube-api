<?php

namespace Tests\Unit\Services;

use App\Services\HorizontalRotationService;
use App\Services\RotationService;
use App\Services\VerticalRotationService;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\CubeDataProviderTrait;
use Tests\InvokePrivateMethodTrait;

class RotationServiceTest extends \Tests\TestCase
{
    use InvokePrivateMethodTrait, CubeDataProviderTrait;

    private HorizontalRotationService|MockObject|null $horizontalRotationServiceMock;
    private VerticalRotationService|MockObject|null $verticalRotationServiceMock;
    private RotationService|null $rotationService;

    public function setUp(): void
    {
        parent::setUp();
        $this->horizontalRotationServiceMock = $this->getMockBuilder(HorizontalRotationService::class)
            ->getMock();
        $this->verticalRotationServiceMock = $this->getMockBuilder(VerticalRotationService::class)
            ->getMock();
        $this->rotationService = new RotationService(
            $this->horizontalRotationServiceMock,
            $this->verticalRotationServiceMock
        );
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->verticalRotationServiceMock = null;
        $this->horizontalRotationServiceMock = null;
        $this->rotationService = null;
    }

    public function testisHorizontalDirectionTrue(): void
    {
        $result = $this->invokePrivateMethod($this->rotationService, 'isHorizontalDirection', ['direction' => 'left']);

        $this->assertTrue($result);
    }

    public function testisHorizontalDirectionFalse(): void
    {
        $result = $this->invokePrivateMethod($this->rotationService, 'isHorizontalDirection', ['direction' => 'up']);

        $this->assertFalse($result);
    }

    /**
     * @dataProvider cubeDataProvider
     */
    public function testRotateShouldReturnHorizontallyRotatedCube(array $cube, string $direction, string $rotationEl)
    {
        $expected = [
            'front' => [
                ['green', 'green', 'green'],
                ['red', 'red', 'red'],
                ['green', 'green', 'green'],
            ],
            'right' => [
                ['red', 'red', 'red'],
                ['blue', 'blue', 'blue'],
                ['red', 'red', 'red'],
            ],
            'back' => [
                ['blue', 'blue', 'blue'],
                ['orange', 'orange', 'orange'],
                ['blue', 'blue', 'blue'],
            ],
            'left' => [
                ['orange', 'orange', 'orange'],
                ['green', 'green', 'green'],
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
        $this->horizontalRotationServiceMock->expects($this->once())
            ->method('rotate')
            ->willReturn($expected);
        $result = $this->rotationService->rotate($cube, $direction, $rotationEl);

        $this->assertSame($expected, $result);
    }

    public function cubeDataProvider()
    {
        $cube = $this->getCube();

        return [
            [$cube, 'left', 'middle']
        ];
    }
}
