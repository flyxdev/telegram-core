<?php

namespace race\plugin;

use race\api\TelegramApi;

interface Plugin
{
    public function __construct(TelegramApi $api, string $dataFolder);

    public function isEnabled(): bool;
}