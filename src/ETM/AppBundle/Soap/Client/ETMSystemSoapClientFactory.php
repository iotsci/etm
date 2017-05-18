<?php

namespace ETM\AppBundle\Soap\Client;

class ETMSystemSoapClientFactory
{
    private $wsdl;
    private $pathToPrivateKey;
    private $pathToCert;

    public function __construct($wsdl, $pathToCert, $pathToPrivateKey)
    {
        $this->wsdl = $wsdl;
        $this->pathToCert = $pathToCert;
        $this->pathToPrivateKey = $pathToPrivateKey;
    }

    public function create()
    {
        $client = new ETMSystemSoapClient($this->wsdl);

        $client
            ->setPathToCert($this->pathToCert)
            ->setPathToPrivateKey($this->pathToPrivateKey);

        return $client;
    }
}
