<?php

namespace Main;

use race\event\Listener;
use race\plugin\PluginBase;

class Main extends PluginBase implements Listener
{
    public function execute(): void
    {
        $this->getApi()->apiRequest('sendMessage', ['chat_id' => 5041808375, 'text' => '123']);
    }
}