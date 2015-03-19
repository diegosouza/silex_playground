<?php

namespace Todo\Repositories;

use Todo\Repositories\RepositoryInterface;


abstract class DatabaseRepository implements RepositoryInterface
{
    protected $db;
}
