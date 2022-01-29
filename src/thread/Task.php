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

use core\plugin\PluginManager;

class Task extends \Threaded
{
    private array $updates;
    private PluginManager $manager;

    function __construct(array $updates, PluginManager $plugins)
    {
        $this->manager = $plugins;
        $this->updates = $updates;
    }

    public function run()
    {
        $logger = $this->worker->getLogger();
        $user_id = $this->updates['message']['from']['id'];
        $args = explode(" ", $this->updates['message']['text']);

        $logger->warning("New message from {$user_id} threaded id: " . $this->worker->getThreadId());

        foreach ($this->manager->plugins as $key => $data) {
            if (preg_match("/^({$data['regex']})$/", mb_strtolower($args[0], 'UTF-8'))) {
                $data['plugin']->execute();
            }
        }
    }
}
