<?php

namespace core\thread;

use core\utils\Logger;

class Worker extends \Worker
{
    public array $process = [];
    public ?Logger $logger = null;

    public function __construct()
    {
        $this->logger = new Logger();
    }

    public function run()
    {
    }

    public function getLogger()
    {
        return $this->logger;
    }

    public function addProcess($id)
    {
        //if ($this->api->isOneThread()) {
            $this->process[] = $id;
        //}
    }

    public function delProcess($id)
    {
        //if ($this->api->isOneThread()) {
            unset($this->process[array_search($id, (array) $this->process)]);
        //}
    }

    public function canHandle($id)
    {
        return !in_array($id, (array) $this->process);
    }
}
