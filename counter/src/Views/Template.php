<?php

declare(strict_types=1);

namespace Counter\Views;

/**
 * Class Template
 *
 * @package Counter\Views
 */
class Template
{
    /**
     * @param array $vars
     */
    public function render(string $template, array $vars)
    {
        extract($vars);

        include "/var/www/html/templates/{$template}.phtml";
    }
}
