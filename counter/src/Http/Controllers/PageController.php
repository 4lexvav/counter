<?php

declare(strict_types=1);

namespace Counter\Http\Controllers;

use Counter\Helpers\Logger;
use Counter\Services\Counter;
use Counter\Services\StringProcessor;
use Counter\Views\Template;
use Exception;

/**
 * Class PageController
 *
 * @package Counter\Http\Controllers
 */
class PageController
{
    const FILE_USERS = 'users_counter.txt';
    const FILE_HITS = 'hits_counter.txt';

    /**
     * @var Template
     */
    private $template;
    /**
     * @var StringProcessor
     */
    private $stringProcessor;

    public function __construct()
    {
        $this->stringProcessor = new StringProcessor();
        $this->template = new Template();
    }

    /**
     * @param string $page
     * @throws Exception
     */
    public function register(string $page)
    {
        $pageCounterFile = strip_tags($page) . '.txt';

        $usersCounter = new Counter(self::FILE_USERS);
        $hitsCounter = new Counter(self::FILE_HITS);
        $pageCounter = new Counter($pageCounterFile);

        $hitsCounter->increment();

        if (!isset($_SESSION['visited'])) {
            $usersCounter->increment();
            $_SESSION['visited'] = true;
        }

        $pageKey = 'visited:' . $page;
        if (!isset($_SESSION[$pageKey])) {
            $pageCounter->increment();
            $_SESSION[$pageKey] = $_SERVER['REQUEST_TIME_FLOAT'];
        }

        $this->template->render('main', compact('page', 'usersCounter', 'hitsCounter', 'pageCounter'));
    }

    /**
     * @throws Exception
     */
    public function unregister()
    {
        $input = (string) file_get_contents('php://input');
        if (!$input) {
            throw new Exception('Error decrementing counter, missing input.');
        }

        $data = json_decode($input, true);
        if (!is_array($data) || !isset($data['page'])) {
            throw new Exception('Error decrementing counter, invalid input data.');
        }

        $page = $this->stringProcessor->process($data['page']);
        $pageFile = $page . '.txt';

        Logger::debug('Page hit: ' . $_SERVER['REQUEST_URI'], [
            'page' => $page ? $page : 'absent',
            'request time' => $_SERVER['REQUEST_TIME_FLOAT'],
            'session' => session_id(),
        ]);

        $time = $_SESSION['visited:' . $page] ?? null;
        if ($time && $time < $_SERVER['REQUEST_TIME_FLOAT']) {
            unset($_SESSION['visited:' . $page]);

            $pageCounter = new Counter($pageFile);
            $pageCounter->decrement();
        }
    }
}
