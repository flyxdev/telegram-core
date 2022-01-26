<?php

namespace race;

use race\api\TelegramApi;
use race\exceptions\BotException;
use race\plugin\PluginManager;
use race\thread\BotWorker;
use race\thread\Task;
use race\utils\Logger;

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
        $logger->log("Bot is starting up..");

        $config_file = dirname(__FILE__, 2) . '/config.json';
        if (!is_file($config_file)) {
            throw new BotException("Конфигурационный файл не найден по пути: " . $config_file);
            exit(1);
        }
        $config = json_decode(file_get_contents($config_file), true);
        $logger->log("Config loading done..");

        $logger = new Logger();
        $pluginLoader = new PluginManager($logger, dirname(__FILE__, 2) . '/plugins');
        $logger->log(json_encode($pluginLoader->loadPlugins(dirname(__FILE__, 2) . '/plugins')));

        $api = new TelegramApi($config['bot']['access_token']);
        $pool = new \Pool(16, BotWorker::class);

        $logger->log("Loading done in: " . substr((microtime(true) - $this->start), 0, -12) . " ms");
        while (true) {
            foreach ($api->apiRequest("getUpdates", ['offset' => static::$update_id]) as $key => $updates) {
                $pool->submit((new Task($updates, $pluginLoader)));
                static::$update_id = $updates['update_id'] + 1;
            }
        }

    }
}

(new \race\Server)->init();
