<?php

namespace Tests\Unit\Services;

use App\Services\HorizontalRotationService;
use Tests\CubeDataProviderTrait;
use Tests\InvokePrivateMethodTrait;

class HorizontalRotationServiceTest extends \Tests\TestCase
{
    use InvokePrivateMethodTrait, CubeDataProviderTrait;

    private HorizontalRotationService|null $horizontalRotationService;

    public function setUp(): void
    {
        parent::setUp();
        $this->horizontalRotationService = new HorizontalRotationService();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->horizontalRotationService = null;
    }

    public function testIsMiddleRowMovedShouldReturnTrue(): void
    {
        $result = $this->invokePrivateMethod(
            $this->horizontalRotationService,
            'isMiddleRowMoved',
            ['row' => 'middle']
        );

        $this->assertTrue($result);
    }

    public function testIsMiddleRowMovedShouldReturnFalse(): void
    {
        $result = $this->invokePrivateMethod(
            $this->horizontalRotationService,
            'isMiddleRowMoved',
            ['row' => 'top']
        );

        $this->assertFalse($result);
    }

    public function testIsDirectionToTheLeftShouldReturnTrue(): void
    {
        $result = $this->invokePrivateMethod(
            $this->horizontalRotationService,
            'isDirectionToLeft',
            ['direction' => 'left']
        );

        $this->assertTrue($result);
    }

    public function testIsDirectionToTheLeftShouldReturnFalse(): void
    {
        $result = $this->invokePrivateMethod(
            $this->horizontalRotationService,
            'isDirectionToLeft',
            ['direction' => 'right']
        );

        $this->assertFalse($result);
    }

    /**
     * @dataProvider flattenDataProvider
     */
    public function testFlattenShouldReturnOneDimensionalArray(array $cube, int $row): void
    {
        $expected = [
            'green',
            'green',
            'green',
            'red',
            'red',
            'red',
            'blue',
            'blue',
            'blue',
            'orange',
            'orange',
            'orange'
        ];
        $result = $this->invokePrivateMethod(
            $this->horizontalRotationService,
            'flatten',
            ['cube' => $cube, 'row' => $row]
        );

        $this->assertSame($expected, $result);
    }

    /**
     * @dataProvider cubeRowDataProviderLeftDirection
     */
    public function testRotateRowToLeft(array $data, string $direction): void
    {
        $expected = [
            'red',
            'red',
            'red',
            'blue',
            'blue',
            'blue',
            'orange',
            'orange',
            'orange',
            'green',
            'green',
            'green'
        ];
        $result = $this->invokePrivateMethod(
            $this->horizontalRotationService,
            'rotateRow',
            ['data' => $data, 'direction' => $direction]
        );

        $this->assertSame($expected, $result);
    }

    /**
     * @dataProvider cubeRowDataProviderRightDirection
     */
    public function testRotateRowToRight(array $data, string $direction): void
    {
        $expected = [
            'orange',
            'orange',
            'orange',
            'green',
            'green',
            'green',
            'red',
            'red',
            'red',
            'blue',
            'blue',
            'blue'
        ];
        $result = $this->invokePrivateMethod(
            $this->horizontalRotationService,
            'rotateRow',
            ['data' => $data, 'direction' => $direction]
        );

        $this->assertSame($expected, $result);
    }

    /**
     * @dataProvider getNewRowDataDataProvider
     */
    public function testGetNewRowData(array $rotatedData): void
    {
        $expected = [
            'front' => ['orange', 'orange', 'orange'],
            'right' => ['green', 'green', 'green'],
            'back' => ['red', 'red', 'red'],
            'left' => ['blue', 'blue', 'blue',]
        ];
        $result = $this->invokePrivateMethod(
            $this->horizontalRotationService,
            'getNewRowData',
            ['rotatedData' => $rotatedData]
        );

        $this->assertSame($expected, $result);
    }

    /**
     * @dataProvider replaceOldValuesWithNewDataProvider
     */
    public function testReplaceOlvValuesWithNew(array $cube, array $newRow, int $index): void
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
        $result = $this->invokePrivateMethod(
            $this->horizontalRotationService,
            'replaceOldValuesWithNew',
            ['cube' => $cube, 'newRow' => $newRow, 'index' => $index]
        );

        $this->assertSame($expected, $result);
    }

    /**
     * @dataProvider rotateDataProvider
     */
    public function testRotateShouldRotateCube(array $cube, string $direction, string $rotationEl): void
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
        $result = $this->horizontalRotationService->rotate($cube, $direction, $rotationEl);

        $this->assertSame($expected, $result);
    }

    public function flattenDataProvider(): array
    {
        $cube = $this->getCube();

        return [
            [$cube, 1]
        ];
    }

    public function cubeRowDataProviderLeftDirection()
    {
        $singleRow = $this->getCubeRow();

        return [
            [
                $singleRow,
                'left'
            ]
        ];
    }

    public function cubeRowDataProviderRightDirection()
    {
        $singleRow = $this->getCubeRow();

        return [
            [
                $singleRow,
                'right'
            ]
        ];
    }

    public function getNewRowDataDataProvider()
    {
        return [
            [
                [
                    'orange',
                    'orange',
                    'orange',
                    'green',
                    'green',
                    'green',
                    'red',
                    'red',
                    'red',
                    'blue',
                    'blue',
                    'blue'
                ]
            ]
        ];
    }

    public function replaceOldValuesWithNewDataProvider()
    {
        $cube = $this->getCube();

        return [
            [
                $cube,
                [
                    'front' => ['red', 'red', 'red'],
                    'right' => ['blue', 'blue', 'blue'],
                    'back' => ['orange', 'orange', 'orange'],
                    'left' => ['green', 'green', 'green']
                ],
                0
            ]
        ];
    }

    public function rotateDataProvider()
    {
        $cube = $this->getCube();

        return [
            [$cube, 'left', 'top']
        ];
    }
}
