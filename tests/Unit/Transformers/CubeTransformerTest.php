<?php

declare(strict_types=1);

namespace Tests\Unit\Transformers;

use App\Transformers\CubeTransformer;
use App\Transformers\HorizontalTransformer;
use App\Transformers\VerticalTransformer;
use JetBrains\PhpStorm\Pure;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\CubeDataProviderTrait;
use Tests\InvokePrivateMethodTrait;
use Tests\TestCase;

class CubeTransformerTest extends TestCase
{
    use InvokePrivateMethodTrait, CubeDataProviderTrait;

    private HorizontalTransformer|MockObject|null $horizontalTransformerMock;
    private VerticalTransformer|MockObject|null $verticalTransformerMock;
    private CubeTransformer|null $cubeTransformer;

    public function setUp(): void
    {
        parent::setUp();
        $this->horizontalTransformerMock = $this->getMockBuilder(HorizontalTransformer::class)
            ->getMock();
        $this->verticalTransformerMock = $this->getMockBuilder(VerticalTransformer::class)
        ->getMock();
        $this->cubeTransformer = new CubeTransformer(
            $this->horizontalTransformerMock,
            $this->verticalTransformerMock
        );
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->verticalTransformerMock = null;
        $this->horizontalTransformerMock = null;
        $this->cubeTransformer = null;
    }

    public function testisHorizontalDirectionTrue(): void
    {
        $result = $this->invokePrivateMethod($this->cubeTransformer, 'isHorizontalDirection', ['direction' => 'left']);

        $this->assertTrue($result);
    }

    public function testisHorizontalDirectionFalse(): void
    {
        $result = $this->invokePrivateMethod($this->cubeTransformer, 'isHorizontalDirection', ['direction' => 'up']);

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
        $this->horizontalTransformerMock->expects($this->once())
            ->method('rotate')
            ->willReturn($expected);
        $result = $this->cubeTransformer->rotate($cube, $direction, $rotationEl);

        $this->assertSame($expected, $result);
    }

    #[Pure] public function cubeDataProvider()
    {
        $cube = $this->getCube();

        return [
            [$cube, 'left', 'middle']
        ];
    }
}
