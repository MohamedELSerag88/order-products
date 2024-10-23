<?php

namespace App\Http\Repositories;

interface BaseRepositoryInterface
{
    public function all();


    public function find($id);

    public function create(array $data);

    public function update(array $data, $id);
}
