<?php

namespace ETM\AppBundle\Tests;

use ETM\AppBundle\Converter\ConverterInterface;
use ETM\AppBundle\Converter\ObjectToArrayConverter;
use ETM\AppBundle\Test\TestType;
use ETM\AppBundle\Types\BaseType;
use ETM\AppBundle\Types\DoAirFareRQ;
use ETM\AppBundle\Types\GetAirFareRQ;
use ETM\AppBundle\Types\OriginDestinationInformationType;
use ETM\AppBundle\Types\PassengerQuantityType;
use ETM\AppBundle\Types\Security;
use ETM\AppBundle\Types\TravelerInfoSummaryType;

class ObjectToArrayConverterTest extends \PHPUnit_Framework_TestCase
{

    /** @var ConverterInterface $converter */
    protected $converter;
    /** @var BaseType $testType */
    protected $testType;

    protected function setUp()
    {
        $this->converter = $this->createConverter();
        $this->testType = $this->createTestType();
    }

    public function testSimpleObject()
    {

        $this->testType->User = 'user';

        $result = $this->converter->convert($this->testType);

        $expect = ['User' => 'user'];

        $this->assertEquals($expect, $result);
    }

    public function testObjectWithIncludeOtherObjects()
    {
        $this->testType->Object = new \stdClass();
        $this->testType->Object->TestProperty = 'test';

        $expect = [
            'Object' => [
                'TestProperty' => 'test'
            ]
        ];

        $result = $this->converter->convert($this->testType);

        $this->assertEquals($expect, $result);
    }

    public function testObjectWithArrayOfObjects()
    {
        $object1 = new \stdClass();
        $object1->TestProperty1 = 'test1';
        $object2 = new \stdClass();
        $object2->TestProperty2 = 'test2';

        $this->testType->Array = [$object1, $object2];

        $expect = [
            'Array' => [
                ['TestProperty1' => 'test1'],
                ['TestProperty2' => 'test2'],
            ]
        ];

        $result = $this->converter->convert($this->testType);

        $this->assertEquals($expect, $result);
    }

    public function testGetAirFareRQ()
    {
        $security = new Security('username', 'password', 'hash');
        $originDestinationInformation = new OriginDestinationInformationType(
            new \DateTime('2017-05-18'),
            'from',
            'to'
        );
        $passengerQuantityType = new PassengerQuantityType(PassengerQuantityType::ADT, 1);
        $travelInfoSummary = new TravelerInfoSummaryType($passengerQuantityType);

        $DoAirFareRQ = (new DoAirFareRQ($security))
            ->addTravelInfoSummary($travelInfoSummary)
            ->addOriginDestinationInformation($originDestinationInformation);

        $result = $this->converter->convert($DoAirFareRQ);

        $expect = [
            'Security' => [
                'Username' => 'username',
                'Password' => 'password',
                'HashKey' => 'hash',
            ],
            'OriginDestinationInformation' => [
                [
                    'DepartureDateTime' => (new \DateTime('2017-05-18'))->format('c'),
                    'OriginLocation' => 'from',
                    'DestinationLocation' => 'to',
                ]
            ],
            'TravelerInfoSummary' => [
                [
                    'Passenger' => [
                        'Type' => PassengerQuantityType::ADT,
                        'Quantity' => 1,
                    ],
                ]
            ],
            'TravelPreferences' => null,
        ];

        $this->assertEquals($expect, $result);
    }

    protected function createTestType()
    {
        return new TestType();
    }

    protected function createConverter()
    {
        return new ObjectToArrayConverter();
    }
}
