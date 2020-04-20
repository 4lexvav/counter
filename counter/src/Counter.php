<?php

declare(strict_types=1);

/**
 * Class Counter
 */
class Counter {
    /**
     *
     */
    private const MODE = 'r+';

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
     */
    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
        $this->fp = fopen($fileName, self::MODE);
        if (!flock($this->fp, LOCK_EX)) {
            exit('Could not get the lock!');
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
    public function __destruct()
    {
        flock($this->fp, LOCK_UN);
        fclose($this->fp);
    }
}
