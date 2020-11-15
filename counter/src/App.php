<?php

declare(strict_types=1);

namespace Counter;

use Counter\Helpers\Logger;
use Counter\Http\Controllers\PageController;
use Counter\Services\Error;
use Counter\Services\StringProcessor;
use Exception;

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
     * @var StringProcessor
     */
    private $stringProcessor;

    /**
     * App constructor.
     */
    public function __construct()
    {
        (new Error())->init();

        $this->stringProcessor = new StringProcessor();
        $this->pageController = new PageController();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        $page = $this->stringProcessor->process(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        if (method_exists($this->pageController, $page)) {
            call_user_func([$this->pageController, $page]);
            return;
        }

        Logger::debug('Page hit: ' . $_SERVER['REQUEST_URI'], [
            'request time' => $_SERVER['REQUEST_TIME_FLOAT'],
            'session' => session_id(),
        ]);

        $this->pageController->register($page);
    }
}
