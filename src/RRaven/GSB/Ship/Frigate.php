<?php


namespace RRaven\GSB\Ship;

/**
 * Class Frigate
 * A nimble but lightly armed ship
 * 
 * @package RRaven\GSB\Ship
 */
class Frigate extends AbstractShip
{
    /**
     * @param int $attack points of the ship (default 5)
     * @param int $defence points of the ship (default 25)
     */
    public function __construct($attack = 5, $defence = 25)
    {
        parent::__construct($attack, $defence);
    }
}
