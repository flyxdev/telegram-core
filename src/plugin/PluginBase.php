<?php

namespace race\plugin;

use race\api\TelegramApi;
use race\plugin\Plugin;

abstract class PluginBase implements Plugin
{
    private TelegramApi $api;

    private bool $isEnabled = false;

    private string $dataFolder;
}
