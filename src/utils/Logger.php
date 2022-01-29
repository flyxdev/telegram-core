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
        return $this->log("\033[0;36m", "INFO", $message);
    }

    public function error(?string $message)
    {
        return $this->log("\033[0;31m", "ERROR", $message);
    }

    public function warning(?string $message)
    {
        return $this->log("\033[1;33m", "WARNING", $message);
    }
}
