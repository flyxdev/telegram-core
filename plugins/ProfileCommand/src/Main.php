<?php

namespace ProfileCommand;

use core\plugin\PluginBase;

class Main extends PluginBase
{
    public function execute(): void
    {
        $this->getApi()->apiRequest('sendMessage', ['chat_id' => 5041808375, 'text' => 'ваш профиль']);
    }
}