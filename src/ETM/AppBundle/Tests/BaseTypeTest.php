<?php

namespace ETM\AppBundle\Tests;

use ETM\AppBundle\Soap\Types\GetAirFareRQ;
use ETM\AppBundle\Soap\Types\Security;

class BaseTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAirFareRQGetArray()
    {
        $security = new Security('test', 'pass', 'hash');
        $getAirFareRQ = new GetAirFareRQ($security, 1);

        $expectedArray = [
            'Security' => [
                'Username' => 'test',
                'Password' => 'pass',
                'HashKey' => 'hash',
            ],
            'RequestId' => 1
        ];

        self::assertEquals($expectedArray, $getAirFareRQ->getArray());
    }
}
