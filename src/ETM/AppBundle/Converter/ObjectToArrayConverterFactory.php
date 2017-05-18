<?php

namespace ETM\AppBundle\Converter;

class ObjectToArrayConverterFactory
{

    public function create()
    {
        return new ObjectToArrayConverter();
    }
}