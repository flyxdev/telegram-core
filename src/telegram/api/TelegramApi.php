<?php

namespace core\api;

use core\telegram\exceptions\TelegramApiErrorException;

class TelegramApi
{
    public static int|float $user_id;
    public static int|float $chat_id;
    public string $token = '';
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
