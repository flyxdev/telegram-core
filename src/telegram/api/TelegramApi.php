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

namespace core\api;

use core\telegram\exceptions\TelegramApiErrorException;

class TelegramApi
{
    public static int|float $user_id;
    public static int|float $chat_id;
    private string $token = '';
    public string $api_url = "https://api.telegram.org";

    public function __construct(?string $token)
    {
        $this->token = $token;
    }

    public function apiRequest(?string $method, array $params = [])
    {
        $arrContextOptions = [
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ],
        ];

        $request = json_decode(file_get_contents("{$this->api_url}/bot{$this->token}/{$method}?" . http_build_query($params), context: stream_context_create($arrContextOptions)), true);

        if (isset($request['result'])) {
            return $request['result'];
        } else {
            throw new TelegramApiErrorException(json_encode($request));
        }
    }
}
