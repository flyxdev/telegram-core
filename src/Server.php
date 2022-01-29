<?php

/*
 *
 *  ____            _        _    ____
 * |  _ \ ___   ___| | _____| |_ / ___|___  _ __ ___
 * | |_) / _ \ / __| |/ / _ \ __| |   / _ \| '__/ _ \
 * |  __/ (_) | (__|   <  __/ |_| |__| (_) | | |  __/
 * |_|   \___/ \___|_|\_\___|\__|\____\___/|_|  \___|

 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author flyxdev
 *
 *
*/

namespace core;

use core\api\TelegramApi;
use core\exceptions\BotException;
use core\plugin\PluginManager;
use core\thread\Worker;
use core\thread\Task;
use core\utils\Logger;

class Server
{
    public static ?int $update_id = 0;
    public int|float $start;

    public function __construct()
    {
        $this->start = microtime(true);
    }

    public function init()
    {
        $bootstrap = dirname(__FILE__, 2) . '/vendor/autoload.php';
        if (!is_file($bootstrap)) {
            throw new BotException("Composer автозагрузчик не найден по пути: " . $bootstrap);
            exit(1);
        }
        require_once($bootstrap);
        $logger = new Logger();
        $logger->warning("Bot is starting up..", [1, 2, 3]);

        $config_file = dirname(__FILE__, 2) . '/config.json';
        if (!is_file($config_file)) {
            throw new BotException("Конфигурационный файл не найден по пути: " . $config_file);
            exit(1);
        }
        $config = json_decode(file_get_contents($config_file), true);
        $logger->info("Config loading done..");
        
        $api = new TelegramApi($config['bot']['access_token']);
        $logger->info("Telegram API connected..");

        $logger = new Logger();
        $pluginLoader = new PluginManager($logger, $api, dirname(__FILE__, 2) . '/plugins');
        $plugins = $pluginLoader->loadPlugins(dirname(__FILE__, 2) . '/plugins');

        $pool = new \Pool(16, Worker::class);

        $logger->warning("Loading done in: " . substr((microtime(true) - $this->start), 0, -12) . " ms");
        while (true) {
            foreach ($api->apiRequest("getUpdates", ['offset' => static::$update_id]) as $key => $updates) {
                $pool->submit((new Task($updates, $pluginLoader)));
                static::$update_id = $updates['update_id'] + 1;
            }
        }

    }
}

(new \core\Server)->init();
