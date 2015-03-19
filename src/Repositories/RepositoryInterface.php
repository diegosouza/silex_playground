<?php

namespace Todo\Repositories;


interface RepositoryInterface
{
    public function all();
    public function save($model);
}
