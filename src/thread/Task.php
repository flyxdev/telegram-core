<?php

namespace race\thread;

use race\plugin\PluginBase;
use race\plugin\PluginManager;

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

        $logger->log(json_encode($this->updates));
        $logger->log("New message from {$user_id} threaded id: " . $this->worker->getThreadId());

        foreach ($this->manager->plugins as $key => $data) {
            if (preg_match("/^({$data['regex']})$/", mb_strtolower($args[0], 'UTF-8'))) {
                $data['plugin']->execute();
            }
        }
    }
}
