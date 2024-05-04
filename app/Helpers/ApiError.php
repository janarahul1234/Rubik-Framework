<?php

namespace App\Helpers;

use App\core\utils\Json;
use App\core\Response;

class ApiError
{
    public static function createError(int $code, string $message, string|array $details = null): string
    {
        $error = [
            'code' => $code,
            'message' => $message
        ];

        if ($details !== null) {
            $error['details'] = $details;
        }

        $json = new Json();
        $response = new Response();

        $response->setStatusCode($code);
        return $json->send(['error' => $error]);
    }
}
