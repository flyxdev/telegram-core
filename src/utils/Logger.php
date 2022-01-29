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
