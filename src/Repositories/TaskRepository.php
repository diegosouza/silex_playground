<?php

namespace Todo\Repositories;

use Todo\Repositories\DatabaseRepository;
use Todo\Models\Task;


class TaskRepository extends DatabaseRepository
{
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function all()
    {
        return $this->db->tasks->fetchAll();
    }

    public function save($model)
    {
        $this->db->tasks->persist($model);
        $this->db->flush();
    }

    public function remove($model)
    {
        $this->db->tasks->remove($model);
        $this->db->flush();
    }
}
