<?php

namespace App\Helpers;

abstract class Direction
{
    public const LEFT = 'left';
    public const RIGHT = 'right';
    public const UP = 'up';
    public const DOWN = 'down';
    public const HORIZONTAL = [self::LEFT, self::RIGHT];
}
