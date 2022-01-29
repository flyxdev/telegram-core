<?php

/*
 *
 *  ____            _        _    ____
 * |  _ \ ___   ___| | _____| |_ / ___|___  _ __ ___
 * | |_) / _ \ / __| |/ / _ \ __| |   / _ \| '__/ _ \
 * |  __/ (_) | (__|   <  __/ |_| |__| (_) | | |  __/
 * |_|   \___/ \___|_|\_\___|\__|\____\___/|_|  \___|

 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author flyxdev
 *
 *
*/

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
