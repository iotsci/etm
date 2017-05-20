<?php

namespace ETM\AppBundle\Types;

class PassengerQuantityType extends BaseType
{
    protected $Type;
    protected $Quantity;

    const ADT = 'ADT';
    const CHD = 'CHD';
    const INF = 'INF';

    public static function getTypes()
    {
        return [
            self::ADT => 'Adult',
            self::CHD => 'Child',
            self::INF => 'Infant',
        ];
    }

    public function __construct($type, $quantity)
    {
        $this->Type = $type;
        $this->Quantity = $quantity;
    }
}