<?php

namespace ETM\AppBundle\Soap\Types;

abstract class BaseType
{

    final public function getArray()
    {
        $reflectionObject = new \ReflectionClass($this);

        return $this->handleArray($reflectionObject->getProperties(), $this);
    }

    private function handleArray(array $properties, $object)
    {
        $resultArray = [];

        /** @var \ReflectionProperty[] $properties */
        foreach ($properties as $property) {

            $property->setAccessible(true);

            $value = $property->getValue($object);
            $keyName = $property->getName();

            if (is_object($value)) {
                $reflectionObject = new \ReflectionClass($value);

                $resultArray[$keyName] = $this->handleArray($reflectionObject->getProperties(), $value);

            } else {
                $resultArray[$keyName] = $value;
            }
        }
        return $resultArray;
    }
}
