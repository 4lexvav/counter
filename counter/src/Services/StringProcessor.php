<?php

declare(strict_types=1);

namespace Counter\Services;

/**
 * Class StringProcessor
 *
 * @package Counter\Services
 */
class StringProcessor
{
    /**
     * @param string $value
     * @return string|string[]
     */
    public function process(string $value)
    {
        return str_replace(['/', '.'], '', strip_tags($value));
    }
}
