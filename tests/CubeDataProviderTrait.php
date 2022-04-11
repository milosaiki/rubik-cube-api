<?php

namespace Tests;

trait CubeDataProviderTrait
{
    public function getCube(): array
    {
        return [
            'front' => [
                ['green', 'green', 'green'],
                ['green', 'green', 'green'],
                ['green', 'green', 'green'],
            ],
            'right' => [
                ['red', 'red', 'red'],
                ['red', 'red', 'red'],
                ['red', 'red', 'red'],
            ],
            'back' => [
                ['blue', 'blue', 'blue'],
                ['blue', 'blue', 'blue'],
                ['blue', 'blue', 'blue'],
            ],
            'left' => [
                ['orange', 'orange', 'orange'],
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
    }

    public function getCubeRow(): array
    {
        return [
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
    }
}
