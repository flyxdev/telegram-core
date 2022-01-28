<?php

namespace race\plugin;

use race\utils\Logger;
use race\api\TelegramApi;

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
