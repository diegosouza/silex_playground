<?php

namespace Todo\Interactors;

use Todo\Repositories\TaskRepository;
use Todo\Models\Task;


class TaskRemoverInteractor
{
    private $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function remove($id)
    {
        $task = new Task('');
        $task->id = $id;

        return $this->repository->remove($task);
    }
}
