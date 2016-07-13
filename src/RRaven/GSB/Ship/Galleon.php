<?php


namespace RRaven\GSB\Ship;

/**
 * Class Galleon
 * A lumbering and well equipped ship
 * 
 * @package RRaven\GSB\Ship
 */
class Galleon extends AbstractShip
{
    /**
     * @param int $attack points of the ship (default 10)
     * @param int $defence points of the ship (default 10)
     */
    public function __construct($attack = 10, $defence = 10)
    {
        parent::__construct($attack, $defence);
    }
}
