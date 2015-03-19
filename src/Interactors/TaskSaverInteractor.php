<?php

namespace Todo\Interactors;

use Todo\Repositories\TaskRepository;


class TaskSaverInteractor
{
    private $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function save($task)
    {
        return $this->repository->save($task);
    }
}
