<?php

namespace ETM\AppBundle\Types;

class GetCustomerOrdersRQ extends BaseType
{
    protected $Security;
    protected $CustomerEmail;
    protected $FromDate;
    protected $ToDate;

    public function __construct(
        Security $security,
        $email,
        \DateTime $fromDate,
        \DateTime $toDate
    )
    {
        $this->Security = $security;
        $this->CustomerEmail = $email;
        $this->FromDate = $fromDate;
        $this->ToDate = $toDate;
    }
}