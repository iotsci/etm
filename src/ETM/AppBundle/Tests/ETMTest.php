<?php

namespace ETM\AppBundle\Tests;

use ETM\AppBundle\Converter\ObjectToArrayConverter;
use ETM\AppBundle\Soap\Client\ETMSystemSoapClient;
use ETM\AppBundle\Types\DoAirFareRQ;
use ETM\AppBundle\Types\GetAirFareRQ;
use ETM\AppBundle\Types\OriginDestinationInformationType;
use ETM\AppBundle\Types\PassengerQuantityType;
use ETM\AppBundle\Types\Security;
use ETM\AppBundle\Types\TravelerInfoSummaryType;
use PHPUnit\Framework\TestCase;

class ETMTest extends TestCase
{
    /** @var ObjectToArrayConverter $converter */
    private $converter;
    /** @var ETMSystemSoapClient $client */
    private $client;

    protected function setUp()
    {
        $this->converter = $this->createConverter();
        $this->client = $this->createSoapClient();
    }

    protected function createSoapClient()
    {
        $this->markTestSkipped('Использовал при разработке. Оставлю для демонстрации.');

        $wsdl = '';
        $pathToCert = '';
        $pathToKey = '';

        return (new ETMSystemSoapClient($wsdl))
            ->setPathToCert($pathToCert)
            ->setPathToPrivateKey($pathToKey);
    }

    protected function createConverter()
    {
        return new ObjectToArrayConverter();
    }

    public function testPing()
    {
        $this->markTestSkipped('Использовал при разработке. Оставлю для демонстрации.');

        $result = $this->client->__soapCall('ETM_Ping', ['pong']);

        self::assertEquals('pong', $result);
    }

    public function testDoAirFareRequest()
    {
        $this->markTestSkipped('Использовал при разработке. Оставлю для демонстрации.');

        $security = $this->createSecurity();
        $originDestinationInformationType = new OriginDestinationInformationType(
            new \DateTime('+1 day'),
            'MOW',
            'MUC'
        );
        $passengerQuantityType = new PassengerQuantityType(PassengerQuantityType::ADT, 1);
        $travelerInfoSummary = new TravelerInfoSummaryType($passengerQuantityType);

        $doAirFareRQ = new DoAirFareRQ($security);
        $doAirFareRQ
            ->addOriginDestinationInformation($originDestinationInformationType)
            ->addTravelInfoSummary($travelerInfoSummary);

        $response = $this->client->__soapCall('ETM_DoAirFareRequest', [$this->converter->convert($doAirFareRQ)]);

        var_dump($response);
    }

    public function testGetAirFareResult()
    {
        $this->markTestSkipped('Использовал при разработке. Оставлю для демонстрации.');


        $security = $this->createSecurity();
        $getAirFareQR = new GetAirFareRQ($security, 214616);

        $response = $this->client->__soapCall('ETM_GetAirFareResult', [$this->converter->convert($getAirFareQR)]);

        var_dump($response);
    }

    protected function createSecurity()
    {
        return new Security('', '', '');
    }
}