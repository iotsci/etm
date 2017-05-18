<?php

namespace ETM\AppBundle\Types;

class TravelPreferencesType extends BaseType
{
    protected $OfficeId;
    protected $VendorPref;
    protected $BookingClassPref;
    protected $OnlyDirectPref;

    public function __construct(
        $officeId = null,
        $vendorPref = null,
        $bookingClassPref = null,
        $onlyDirectPref = null
    )
    {
        $this->OfficeId = $officeId;
        $this->VendorPref = $vendorPref;
        $this->BookingClassPref = $bookingClassPref;
        $this->OnlyDirectPref = $onlyDirectPref;
    }
}