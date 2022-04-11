<?php

namespace Tests\Unit\Services;

use App\Services\VerticalRotationService;
use Tests\CubeDataProviderTrait;
use Tests\InvokePrivateMethodTrait;

class VerticalRotationServiceTest extends \Tests\TestCase
{
    use InvokePrivateMethodTrait, CubeDataProviderTrait;

    private VerticalRotationService|null $verticalRotationService;

    public function setUp(): void
    {
        parent::setUp();
        $this->verticalRotationService = new VerticalRotationService();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->verticalRotationService = null;
    }

    public function testIsMiddleColumnMovedShouldReturnTrue()
    {
        $result = $this->invokePrivateMethod(
            $this->verticalRotationService,
            'isMiddleColumnMoved',
            ['rotationEl' => 'middle']
        );

        $this->assertTrue($result);
    }

    public function testIsMiddleColumnMovedShouldReturnFalse()
    {
        $result = $this->invokePrivateMethod(
            $this->verticalRotationService,
            'isMiddleColumnMoved',
            ['rotationEl' => 'left']
        );

        $this->assertFalse($result);
    }

    public function testIsDirectionUpShouldReturnFalse()
    {
        $result = $this->invokePrivateMethod(
            $this->verticalRotationService,
            'isDirectionUp',
            ['direction' => 'down']
        );

        $this->assertFalse($result);
    }

    public function testIsDirectionUpShouldReturnTrue()
    {
        $result = $this->invokePrivateMethod(
            $this->verticalRotationService,
            'isDirectionUp',
            ['direction' => 'up']
        );

        $this->assertTrue($result);
    }

    /**
     * @dataProvider flattenDataProvider
     */
    public function testFlattenShouldReturnOneDimensionalArray(array $cube, int $index)
    {
        $expected = [
            'green',
            'green',
            'green',
            'white',
            'white',
            'white',
            'blue',
            'blue',
            'blue',
            'yellow',
            'yellow',
            'yellow'
        ];
        $result = $this->invokePrivateMethod(
            $this->verticalRotationService,
            'flatten',
            ['cube' => $cube, 'index' => $index]
        );

        $this->assertSame($expected, $result);
    }

    /**
     * @dataProvider rotateDataDataProvider
     */
    public function testRotateData(array $data, string $direction)
    {
        $expected = [
            'yellow',
            'yellow',
            'yellow',
            'green',
            'green',
            'green',
            'white',
            'white',
            'white',
            'blue',
            'blue',
            'blue'
        ];
        $result = $this->invokePrivateMethod(
            $this->verticalRotationService,
            'rotateData',
            ['data' => $data, 'direction' => $direction]
        );

        $this->assertSame($expected, $result);
    }

    /**
     * @dataProvider getNewRowDataDataProvider
     */
    public function testGetNewRowData(array $rotatedData)
    {
        $expected = [
            'front' => ['yellow', 'yellow', 'yellow'],
            'top' => ['green','green','green'],
            'back' => ['white','white','white'],
            'bottom' => ['blue','blue','blue']
        ];

        $result = $this->invokePrivateMethod(
            $this->verticalRotationService,
            'getNewRowData',
            ['rotatedData' => $rotatedData]
        );

        $this->assertSame($expected, $result);
    }

    /**
     * @dataProvider rotateDataProvider
     */
    public function testRotate(array $cube, string $direction, string $rotationEl)
    {
        $expected = [
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
        $result = $this->verticalRotationService->rotate($cube, $direction, $rotationEl);

        $this->assertSame($expected, $result);
    }

    public function flattenDataProvider(): array
    {
        $cube = $this->getCube();

        return [
            [$cube, 0]
        ];
    }

    public function rotateDataDataProvider(): array
    {
        return [
            [
                [
                    'green',
                    'green',
                    'green',
                    'white',
                    'white',
                    'white',
                    'blue',
                    'blue',
                    'blue',
                    'yellow',
                    'yellow',
                    'yellow'
                ],
                'up'
            ]
        ];
    }

    public function getNewRowDataDataProvider(): array
    {
        return [
            [
                [
                    'yellow',
                    'yellow',
                    'yellow',
                    'green',
                    'green',
                    'green',
                    'white',
                    'white',
                    'white',
                    'blue',
                    'blue',
                    'blue'
                ]
            ]
        ];
    }

    public function rotateDataProvider(): array
    {
        $cube = $this->getCube();

        return [
            [$cube, 'up', 'right']
        ];
    }
}
