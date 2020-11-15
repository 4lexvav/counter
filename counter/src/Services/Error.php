<?php

declare(strict_types=1);

namespace Counter\Services;

use Counter\Helpers\Logger;
use Exception;
use Throwable;

/**
 * Class Error
 */
class Error
{
    /**
     * @return void
     */
    public function init(): void
    {
        set_error_handler([$this, 'errorHandler']);
        set_exception_handler([$this, 'exceptionHandler']);
    }

    /**
     * @param int $errno
     * @param string $errstr
     * @param string $errorFile
     * @param int $errorLine
     * @throws Exception
     */
    public function errorHandler(int $errno, string $errstr, string $errorFile, int $errorLine) {
        throw new Exception("Error: [{$errno}] {$errstr} - {$errorFile}:{$errorLine}");
    }

    /**
     * @param Throwable $exception
     */
    public function exceptionHandler(Throwable $exception) {
        Logger::log($exception->__toString());
        exit('Error occurred. Please, reload the page.');
    }
}
