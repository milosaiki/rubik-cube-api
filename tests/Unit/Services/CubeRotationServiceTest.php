<?php

namespace Tests\Unit\Services;

use App\Services\CubeRotationService;
use App\Transformers\CubeTransformer;
use App\Transformers\CubeTransformerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\CubeDataProviderTrait;
use Tests\TestCase;

class CubeRotationServiceTest extends TestCase
{

    use CubeDataProviderTrait;

    private CubeTransformerInterface|MockObject|null $cubeTransformerMock;
    private CubeRotationService|null $cubeRotationService;

    public function setUp(): void
    {
        parent::setUp();
        $this->cubeTransformerMock = $this->getMockBuilder(CubeTransformer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->cubeRotationService = new CubeRotationService($this->cubeTransformerMock);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->cubeTransformerMock = null;
        $this->cubeRotationService = null;
    }

    /**
     * @dataProvider rotateDataProvider
     */
    public function testRotate(array $cube, string $direction, string $rotationEl)
    {
        $expected = [
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

        $this->cubeTransformerMock->expects($this->once())
            ->method('rotate')
            ->with($cube, $direction, $rotationEl)
            ->willReturn($expected);

        $result = $this->cubeRotationService->rotate($cube, $direction, $rotationEl);

        $this->assertSame($expected, $result);
    }

    public function rotateDataProvider(): array
    {
        $cube = $this->getCube();

        return [
            [$cube, 'left', 'top']
        ];
    }
}
