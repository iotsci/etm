<?php

namespace ETM\AppBundle\Soap\Communicator;

use ETM\AppBundle\Converter\ObjectToArrayConverterFactory;
use ETM\AppBundle\Soap\Client\ETMSystemSoapClientFactory;
use ETM\AppBundle\Types\BaseType;
use ETM\AppBundle\Types\DoAirFareRQ;
use ETM\AppBundle\Types\GetAirFareRQ;
use ETM\AppBundle\Types\OriginDestinationInformationType;
use ETM\AppBundle\Types\PassengerQuantityType;
use ETM\AppBundle\Types\Security;
use ETM\AppBundle\Types\TravelerInfoSummaryType;

class ETMSystemCommunicator implements CommunicatorInterface
{
    protected $client;
    protected $converter;
    protected $security;

    public function __construct(
        ETMSystemSoapClientFactory $soapClientFactory,
        ObjectToArrayConverterFactory $converterFactory,
        Security $security
    )
    {
        $this->client = $soapClientFactory->create();
        $this->converter = $converterFactory->create();
        $this->security = $security;
    }

    public function ping()
    {
        return $this->client->__soapCall('ETM_Ping', ['pong']);
    }

    public function doAirFareRequest($from, $to, \DateTime $dateTime, $passengerType, $passengerQuantity)
    {
        $originDestinationInformation = new OriginDestinationInformationType(
            $dateTime,
            $from,
            $to
        );
        $passengerQuantityType = new PassengerQuantityType($passengerType, $passengerQuantity);
        $travelInfoSummary = new TravelerInfoSummaryType($passengerQuantityType);
        $doAirFareRQ = (new DoAirFareRQ($this->security))
            ->addOriginDestinationInformation($originDestinationInformation)
            ->addTravelInfoSummary($travelInfoSummary);

        return $this->client->__soapCall('ETM_DoAirFareRequest', [$this->convert($doAirFareRQ)]);
    }

    public function getAirFareResult($requestId)
    {
        $getAirFareRQ = new GetAirFareRQ($this->security, $requestId);

        return $this->client->__soapCall('ETM_GetAirFareResult', [$this->convert($getAirFareRQ)]);
    }

    protected function convert(BaseType $object)
    {
        return $this->converter->convert($object);
    }

}
