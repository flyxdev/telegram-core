<?php

namespace core\plugin;

use core\api\TelegramApi;
use core\utils\Logger;
use RuntimeException;

class PluginManager
{
    public array $plugins = [];
    protected ?string $pluginDataDirectory;
    public ?TelegramApi $api = null;
    public ?Logger $logger = null;

    public function __construct(Logger $logger, TelegramApi $api, ?string $pluginDataDirectory)
    {
        $this->logger = $logger;
        $this->api = $api;
        $this->pluginDataDirectory = $pluginDataDirectory;

        if (!is_null($this->pluginDataDirectory)) {
            if (!file_exists($this->pluginDataDirectory)) {
                @mkdir($this->pluginDataDirectory, 0777, true);
            } elseif (!is_dir($this->pluginDataDirectory)) {
                throw new RuntimeException("Plugin data path $this->pluginDataDirectory exists and is not a directory");
            }
        }
    }

    public function getPlugin(?string $name)
    {
        if (isset($this->plugins[$name])) {
            return $this->plugins[$name];
        }

        return null;
    }

    public function getPlugins(): array
    {
        return $this->plugins;
    }

    public function loadPlugins(string $path): array
    {
        foreach (scandir($path) as $files) {
            if (preg_match('/^(.|..)$/', $files)) continue;
            $this->logger->log("[{$files}] Loading plugin..");
            $configPath = $path . '/' . $files . '/plugin.json';
            if (is_file($configPath)) {
                $configPlugin = json_decode(file_get_contents($configPath), true);
            } else {
                throw new RuntimeException("Config file not found");
            }
            require_once("{$path}/{$files}/{$configPlugin['main']}");

            $plugin = new ($configPlugin['name']."\\"."Main")($this->api, $this->logger);

            $this->plugins[] = ["plugin" => $plugin, "regex" => $configPlugin['regex']];
            $this->logger->log("[{$files}] Loading done..");
        }
        return $this->plugins;
    }
}
