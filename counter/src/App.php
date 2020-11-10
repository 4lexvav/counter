<?php

declare(strict_types=1);

namespace Counter;

use Counter\Http\Controllers\PageController;
use Counter\Services\Error;

/**
 * Class App
 *
 * @package App
 */
class App
{
    /**
     * @var PageController
     */
    private $pageController;

    /**
     * App constructor.
     */
    public function __construct()
    {
        (new Error())->init();

        $this->pageController = new PageController();
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $page = trim($_SERVER['PATH_INFO'], '/');
        $action = $page;

        if (!method_exists($this->pageController, $action)) {
            $action = 'register';
        }

        call_user_func([$this->pageController, $action], $page);
    }
}
