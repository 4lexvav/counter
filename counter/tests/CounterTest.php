<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * Class CounterTest
 */
class CounterTest extends TestCase
{
    private const FILE_NAME = 'test.txt';

    /**
     * @var false|resource
     */
    private $fp;

    protected function setUp(): void
    {
        $this->fp = fopen(self::FILE_NAME, 'w+');
    }

    public function testCount()
    {
        $initial = '6';
        $this->write($initial);

        $counter = new Counter(self::FILE_NAME);

        $this->assertNotEquals(0, $counter->count());
        $this->assertEquals($initial, $counter->count());
    }

    public function testIncrement()
    {
        $initial = '6';
        $this->write($initial);

        $counter = new Counter(self::FILE_NAME);
        $counter->increment();

        $this->assertNotEquals($initial, $counter->count());
        $this->assertEquals(intval($initial) + 1, $counter->count());
    }

    /**
     * @param string $content
     */
    private function write(string $content)
    {
        fwrite($this->fp, $content);
        fclose($this->fp);
    }

    protected function tearDown(): void
    {
        unlink(self::FILE_NAME);
    }
}