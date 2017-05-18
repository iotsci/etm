<?php

namespace ETM\AppBundle\Soap\Communicator;

interface CommunicatorInterface
{

    public function ping();
    public function doAirFareRequest($from, $to, \DateTime $dateTime, $passengerType, $passengerQuantity);
    public function getAirFareResult($requestId);


}