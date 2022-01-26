<?php

namespace race\plugin;

use race\api\TelegramApi;
use race\utils\Logger;

interface Plugin
{
    public function __construct(TelegramApi $api, string $dataFolder);

    public function isEnabled(): bool;
    
    public function getLogger(): Logger;
}