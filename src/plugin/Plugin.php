<?php

namespace race\plugin;

use race\api\TelegramApi;
use race\utils\Logger;

interface Plugin
{
    public function __construct(TelegramApi $api, Logger $logger);
}