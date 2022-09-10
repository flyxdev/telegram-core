<?php

namespace core\plugin;

use core\utils\Logger;
use core\telegram\api\TelegramApi;

abstract class PluginBase implements Plugin
{
    public TelegramApi $api;
    public Logger $logger;

    public function __construct(TelegramApi $api, Logger $logger)
    {
        $this->api = $api;
        $this->logger = $logger;
    }

    public function getLogger()
    {
        return $this->logger;
    }

    public function getApi()
    {
        return $this->api;
    }
}
