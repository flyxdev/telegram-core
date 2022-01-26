<?php

namespace race\thread;

use race\api\TelegramApi;

class Task extends \Threaded
{
    private array $updates;

    function __construct(array $updates)
    {
        $this->updates = $updates;
    }

    public function run()
    {
        $logger = $this->worker->getLogger();
        $user_id = $this->updates['message']['from']['id'];

        $logger->log("New message from {$user_id}");
        //$log->apiRequest("sendMessage", ['text' => 123, 'chat_id' => $user_id]);
        sleep(5);
        /*if ($this->worker->canHandle($user_id)) {
            $this->worker->addProcess($user_id);

            $logger->log($this->worker->getThreadId());
            //$logger->log(json_encode($this->updates));
            sleep(5);

            $this->worker->delProcess($user_id);
        }*/
    }
}
