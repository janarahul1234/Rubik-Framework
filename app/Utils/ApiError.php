<?php

namespace App\Helpers;

use App\core\Response;
use App\core\utils\Json;

class ApiError
{
    public static function send(int $code, string $message, string|array $details = null): string
    {
        $json = new Json();
        $response = new Response();

        $error = [
            'code' => (int)$code,
            'message' => $message
        ];

        if ($details !== null) {
            $error['details'] = $details;
        }

        $response->setStatusCode($code);
        return $json->send(['error' => $error]);
    }
}
