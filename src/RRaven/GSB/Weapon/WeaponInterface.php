<?php


namespace RRaven\GSB\Weapon;
use RRaven\GSB\Ship\AbstractShip;

/**
 * Interface WeaponInterface
 * @package RRaven\GSB\Weapon
 */
interface WeaponInterface
{
    /**
     * Returns the multiplier for the weapon shooting at the given target.
     * A miss is represented by returning '0'.
     *
     * @param AbstractShip $target
     * @return int
     */
    public function shootAt(AbstractShip $target);
}
