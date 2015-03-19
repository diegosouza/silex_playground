<?php

namespace Todo\Interactors;

use Todo\Repositories\TaskRepository;


class TaskListInteractor
{
    private $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        return $this->repository->all();
    }
}
