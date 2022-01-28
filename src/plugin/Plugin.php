<?php

namespace core\plugin;

use core\api\TelegramApi;
use core\utils\Logger;

interface Plugin
{
    public function __construct(TelegramApi $api, Logger $logger);
}