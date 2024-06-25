<?php

namespace App\core\utils;

use Dotenv\Dotenv;

class Env
{
    public static function config(): void
    {
        try {
            $dotenv = Dotenv::createImmutable(ROOT_DIR);
            $dotenv->load();
        } catch (\Exception $e) {
            echo 'Please remove the env.example file!';
        }
    }
}
