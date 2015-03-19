<?php

namespace Todo\Models;


class Task
{
    public $text;

    public function __construct($text)
    {
        $this->text = $text;
    }
}
