<?php

namespace race\plugin;

use race\api\TelegramApi;
use race\plugin\Plugin;
use race\utils\Logger;

abstract class PluginBase
{
    private TelegramApi $api;
    public Logger $logger;

    public function __construct()
    {
        $this->logger = new Logger(); 
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }

    public function getApi(): TelegramApi
    {
        $api = new TelegramApi("5260060715:AAHHVnOvYZt_tx3JN61fJDm0VSLn-5mTwPA");
        return $api;
    }
}
