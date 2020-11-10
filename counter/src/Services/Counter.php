<?php

declare(strict_types=1);

namespace Counter\Services;

use Exception;

/**
 * Class Counter
 */
class Counter
{
    private const MODE = 'a+';

    /**
     * @var string
     */
    public $fileName;

    /**
     * @var false|resource
     */
    public $fp;

    /**
     * Counter constructor.
     *
     * @param string $fileName
     *
     * @throws Exception
     */
    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
        $this->fp = fopen($fileName, self::MODE);
        if (!$this->fp) {
            throw new Exception('Error opening file ' . $fileName);
        }

        if (!flock($this->fp, LOCK_EX)) {
            throw new Exception('Could not get the lock!');
        }
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return (int) (file_get_contents($this->fileName) ?? 1);
    }

    /**
     * @return void
     */
    public function increment(): void
    {
        $count = $this->count() + 1;

        ftruncate($this->fp, 0);
        fwrite($this->fp, (string) $count);
    }

    /**
     * @return void
     */
    public function decrement(): void
    {
        $count = $this->count() - 1;

        ftruncate($this->fp, 0);
        fwrite($this->fp, (string) max($count, 0));
    }

    /**
     * @return void
     */
    public function __destruct()
    {
        flock($this->fp, LOCK_UN);
        fclose($this->fp);
    }
}
