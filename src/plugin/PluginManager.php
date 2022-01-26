<?php

namespace race\plugin;

use race\utils\Logger;
use race\plugin\Plugin;
use RuntimeException;

class PluginManager
{
    protected array $plugins = [];

    protected ?string $pluginDataDirectory;

    public function __construct(Logger $logger, ?string $pluginDataDirectory)
    {
        $this->logger = $logger;
        $this->pluginDataDirectory = $pluginDataDirectory;
        if (!is_null($this->pluginDataDirectory)) {
            if (!file_exists($this->pluginDataDirectory)) {
                @mkdir($this->pluginDataDirectory, 0777, true);
            } elseif (!is_dir($this->pluginDataDirectory)) {
                throw new RuntimeException("Plugin data path $this->pluginDataDirectory exists and is not a directory");
            }
        }
    }

    public function getPlugin(?string $name): ?Plugin
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
            $this->logger->log("Loading plugin {$files}..");
            $configPath = $path.'/'.$files.'/plugin.yml';
            if (is_file($configPath)) {
                $configPLugin = \yaml_parse(file_get_contents($configPath));
                var_dump($configPLugin);
            } else {
                throw new RuntimeException("Config file not found");
            }
            require_once("{$path}/{$files}/src/Main/Main.php");

            $plugin = new $configPLugin['main']();
            $plugin->execute();

            //var_dump($configPLugin);
            $this->plugins[] = $files;
        }
        return $this->plugins;
    }
}
