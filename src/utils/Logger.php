<?php

namespace core\utils;

class Logger extends \Threaded
{
    public function log($message, ...$args)
    {
        $this->synchronized(function ($message, ...$args) {
            $cyan = "\033[0;36m";
            $NC = "\033[0m"; # No Color

            if (is_callable($message)) {
                $message(...$args);
            } else echo vsprintf("{$cyan} [INFO] {$message}{$NC}\n", ...$args);
        }, $message, $args);
    }
}
