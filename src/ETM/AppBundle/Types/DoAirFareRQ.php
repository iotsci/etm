<?php

namespace ETM\AppBundle\Types;

class DoAirFareRQ extends BaseType
{
    protected $Security;
    protected $OriginDestinationInformation = [];
    protected $TravelerInfoSummary = [];
    protected $TravelPreferences;

    public function __construct(
        Security $security,
        TravelPreferencesType $travelPreferencesType = null
    )
    {
        $this->Security = $security;
        $this->TravelPreferences = $travelPreferencesType;
    }

    public function addOriginDestinationInformation(OriginDestinationInformationType $originDestinationInformationType)
    {
        $this->OriginDestinationInformation[] = $originDestinationInformationType;
        return $this;
    }

    public function addTravelInfoSummary(TravelerInfoSummaryType $travelerInfoSummaryType)
    {
        $this->TravelerInfoSummary[] = $travelerInfoSummaryType;
        return $this;
    }
}