<?php

namespace Main\Main;

use race\event\Listener;
use race\plugin\PluginBase;

class Main extends PluginBase implements Listener
{
    public function execute(): void
    {
        $this->getLogger()->log("Plugin loading done");
        $this->getLogger()->log(json_encode($this->getApi()->apiRequest("getMe")));
    }
}