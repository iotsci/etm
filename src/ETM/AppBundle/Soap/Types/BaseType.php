<?php

namespace ETM\AppBundle\Soap\Types;

abstract class BaseType
{

    final public function getArray()
    {
        $ref = new \ReflectionClass($this);

        return $this->handleArray($ref->getProperties(), $this);
    }

    private function handleArray(array $properties, $object)
    {
        $resultArray = [];

        /** @var \ReflectionProperty[] $properties */
        foreach ($properties as $property) {

            $property->setAccessible(true);

            if (is_object($property->getValue($object))) {
                $ref = new \ReflectionClass($property->getValue($object));

                $resultArray[$property->getName()] = $this->handleArray($ref->getProperties(), $property->getValue($object));

            } else {
                $resultArray[$property->getName()] = $property->getValue($object);
            }
        }
        return $resultArray;
    }
}
