<?php

namespace core\utils;

class Logger extends \Threaded
{
    public function log(string $color, string $type, ?string $message)
    {
        $this->synchronized(function ($color, $type, $message) {
            $NC = "\033[0m"; # No Color
            echo vsprintf("{$color} [{$type}] {$message}{$NC}\n", []);
        }, $color, $type, $message);
    }

    public function info(?string $message)
    {
        $this->log("\033[0;36m", "INFO", $message);
    }

    public function error(?string $message)
    {
        $this->log("\033[0;31m", "ERROR", $message);
    }

    public function warning(?string $message)
    {
        $this->log("\033[1;33m", "WARNING", $message);
    }
}
