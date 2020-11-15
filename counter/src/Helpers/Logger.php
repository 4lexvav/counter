<?php

declare(strict_types=1);

namespace Counter\Helpers;

/**
 * Class Logger
 *
 * @package Counter\Helpers
 */
class Logger
{
    const DEV = 'dev';

    /**
     * @param string $message
     * @param array $params
     */
    public static function log(string $message, array $params = []): void
    {
        array_walk($params, function ($val, $key) use (&$message) {
            $message .= "; {$key}: {$val}";
        });

        error_log($message);
    }

    /**
     * @param string $message
     * @param array $params
     */
    public static function debug(string $message, array $params = []): void
    {
        if (getenv('MODE') === self::DEV) {
            self::log($message, $params);
        }
    }
}
