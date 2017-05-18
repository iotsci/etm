<?php

namespace ETM\AppBundle\Converter;

use ETM\AppBundle\Types\BaseType;

class ObjectToArrayConverter implements ConverterInterface
{

    public function convert(BaseType $baseType)
    {

        $reflectionObject = new \ReflectionObject($baseType);

        return $this->handle($reflectionObject->getProperties(), $baseType);
    }

    protected function handle(array $properties, $object)
    {
        $resultArray = [];

        /** @var \ReflectionProperty[] $properties */
        foreach ($properties as $property) {

            $property->setAccessible(true);

            $value = $property->getValue($object);
            $keyName = $property->getName();

            if (is_object($value) && !$value instanceof \DateTime) {

                $reflectionObject = new \ReflectionObject($value);
                $result = $this->handle($reflectionObject->getProperties(), $value);
                $resultArray[$keyName] = $result;
            } elseif (is_array($value)) {

                $result = [];

                foreach ($value as $obj) {
                    $reflectionObject = new \ReflectionObject($obj);
                    $result[] = $this->handle($reflectionObject->getProperties(), $obj);
                }

                $resultArray[$keyName] = $result;
            } else {
                $resultArray[$keyName] = $value;
            }
        }
        return $resultArray;
    }
}