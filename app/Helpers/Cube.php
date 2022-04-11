<?php

namespace App\Helpers;

abstract class Cube
{
    public const SIDE_ID_MAPPER = [
        1 => 'front',
        2 => 'top',
        3 => 'right',
        4 => 'left',
        5 => 'bottom',
        6 => 'back'
    ];
    public const HORIZONTAL_SIDE_NAME_ORDER = ['front', 'right', 'back', 'left'];
    public const VERTICAL_SIDE_NAME_ORDER = ['front', 'top', 'back', 'bottom'];
    public const HORIZONTAL_SIDE_ORDER = [1, 3, 6, 4];
    public const VERTICAL_SIDE_ORDER = [1, 2, 6, 5];
    public const VERTICAL_SIDES = [2, 5];
}
