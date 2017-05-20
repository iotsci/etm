<?php

namespace ETM\AppBundle\Tests;

use ETM\AppBundle\IATA\IATAFetcher;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class IATAFetcherTest extends TestCase
{

    public function testFetcher()
    {
        $tmpFile = tempnam('/tmp', 'jsonFetcher_');

        $expect = '["test": "tset"]';

        file_put_contents($tmpFile, $expect);

        $fetcher = new IATAFetcher(new Filesystem(), $tmpFile);

        $this->assertEquals($expect, $fetcher->fetch());

        unlink($tmpFile);
    }

    public function testNotExistsThrowingException()
    {
        $this->expectException(\RuntimeException::class);

        $fetcher = new IATAFetcher(new Filesystem(), 'wrongPath');

        $fetcher->fetch();
    }
}