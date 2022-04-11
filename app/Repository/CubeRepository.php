<?php

namespace App\Repository;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class CubeRepository implements CubeRepositoryInterface
{
    private const CUBE_STARTING_POSITION = [
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
    private const FILE_NAME = 'cube.json';

    private Filesystem $storage;

    public function __construct()
    {
        // TODO: remove and use db instead
        $this->storage = Storage::disk('local');
    }

    public function get()
    {
        $cube = $this->storage->get(self::FILE_NAME);

        if (!empty($cube)) {
            return json_decode($cube, true);
        }

        $this->storage->put(self::FILE_NAME, json_encode(self::CUBE_STARTING_POSITION));

        return self::CUBE_STARTING_POSITION;
    }

    /**
     * @throws \Exception
     */
    public function save(array $data)
    {
        $this->storage->put(self::FILE_NAME, json_encode($data));
    }
}
