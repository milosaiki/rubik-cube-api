<?php

namespace App\Repository;

interface CubeRepositoryInterface
{
    public function get();
    public function save(array $data);
}
