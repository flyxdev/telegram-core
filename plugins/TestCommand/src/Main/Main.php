<?php

namespace Main;

use core\plugin\PluginBase;

class Main extends PluginBase
{
    public function execute(): void
    {
        $this->getApi()->apiRequest('sendMessage', ['chat_id' => 821846834, 'text' => '123']);
    }
}