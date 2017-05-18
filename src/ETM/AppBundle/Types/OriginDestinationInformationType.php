<?php

namespace ETM\AppBundle\Types;

class OriginDestinationInformationType extends BaseType
{
    protected $DepartureDateTime;
    protected $OriginLocation;
    protected $DestinationLocation;

    public function __construct(
        \DateTime $dateTime,
        $originLocation,
        $destinationLocation
    )
    {
        $this->DepartureDateTime = $dateTime;
        $this->OriginLocation = $originLocation;
        $this->DestinationLocation = $destinationLocation;
    }

}
