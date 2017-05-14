<?php

namespace ETM\AppBundle\Soap;

use RobRichards\WsePhp\WSSESoap;
use RobRichards\XMLSecLibs\XMLSecurityKey;

class ETMSystemSoapClient extends \SoapClient
{
    private $pathToCert;
    private $pathToPrivateKey;

    protected function getPathToCert()
    {
        return $this->pathToCert;
    }

    public function setPathToCert($pathToCert)
    {
        $this->pathToCert = $pathToCert;
        return $this;
    }

    protected function getPathToPrivateKey()
    {
        return $this->pathToPrivateKey;
    }

    public function setPathToPrivateKey($pathToPrivateKey)
    {
        $this->pathToPrivateKey = $pathToPrivateKey;
        return $this;
    }

    protected function getCertContent()
    {
        return file_get_contents($this->getPathToCert());
    }

    public function __doRequest($request, $location, $saction, $version, $q = 0) {

        $doc = new \DOMDocument('1.0');
        $doc->loadXML($request);
        $objWSSE = new WSSESoap($doc);

        $objWSSE->addTimestamp();

        $objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, ['type'=>'private']);

        $objKey->loadKey($this->getPathToPrivateKey(), true);

        $objWSSE->signSoapDoc($objKey);

        $token = $objWSSE->addBinaryToken($this->getCertContent());
        $objWSSE->attachTokentoSig($token);

        return parent::__doRequest($objWSSE->saveXML(), $location, $saction, $version);
    }
}
