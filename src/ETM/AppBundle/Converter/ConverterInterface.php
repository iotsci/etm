<?php

namespace ETM\AppBundle\Converter;

use ETM\AppBundle\Types\BaseType;

interface ConverterInterface
{
    public function convert(BaseType $baseType);
}