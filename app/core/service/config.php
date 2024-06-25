<?php

function serverMode()
{
    if ($_ENV['SERVER_MODE'] === 'PRODUCTION') {
        return $_ENV['BASE_URL'];
    }

    if ($_ENV['SERVER_MODE'] === 'DEVELOPMENT') {
        return "http://localhost:{$_SERVER['SERVER_PORT']}";
    }

    throw new \InvalidArgumentException('Invalid server mode!');
}
