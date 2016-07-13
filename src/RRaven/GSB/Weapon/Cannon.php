<?php


namespace RRaven\GSB\Weapon;

use RRaven\GSB\DiceRoller;
use RRaven\GSB\Ship\AbstractShip;

/**
 * Class Cannon
 * Simple cannon. Can be fitted on most ships.
 *
 * @package RRaven\GSB\Weapon
 */
class Cannon implements WeaponInterface
{
    private $roller;
    private $accuracy = 25;
    private $critical = 10;

    public function __construct(DiceRoller $roller)
    {
        $this->roller = $roller;
    }
    
    public function shootAt(AbstractShip $target)
    {
        $roll = $this->roller->roll();
        if ($roll < $this->accuracy) {
            return 0;
        }
        if ($roll > 100 - $this->critical) {
            return 3;
        }
        return 1;
    }
}
