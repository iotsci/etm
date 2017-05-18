<?php

namespace ETM\AppBundle\Types;

class TravelerInfoSummaryType extends BaseType
{
    protected $Passenger;

    public function __construct(PassengerQuantityType $passengerQuantityType)
    {
        $this->Passenger = $passengerQuantityType;
    }
}