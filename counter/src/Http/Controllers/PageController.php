<?php

declare(strict_types=1);

namespace Counter\Http\Controllers;

use Counter\Services\Counter;
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

    public function __construct()
    {
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
            $_SESSION[$pageKey] = true;
        }

        $this->template->render('main', compact('page', 'usersCounter', 'hitsCounter', 'pageCounter'));
    }

    /**
     * @throws Exception
     */
    public function unregister()
    {
        $input = (string) file_get_contents('php://input');
        $data = json_decode($input, true);
        if (!$input || !is_array($data) || !isset($data['page'])) {
            throw new Exception('Error decrementing counter');
        }

        $page = trim(strip_tags($data['page']), '/');
        $pageFile = $page . '.txt';

        $pageCounter = new Counter($pageFile);
        $pageCounter->decrement();

        unset($_SESSION['visited:' . $page]);
    }
}
