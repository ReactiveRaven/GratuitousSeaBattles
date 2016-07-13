<?php


namespace RRaven\GSB\Ship;

use RRaven\GSB\Weapon\WeaponInterface;

/**
 * Class AbstractShip
 * Abstract base class to handle common concrete methods for all ships
 *
 * @package RRaven\GSB\Ship
 */
abstract class AbstractShip
{
    /**
     * @var int Attack points of the ship
     */
    private $attack;

    /**
     * @var int Defence points of the ship
     */
    private $defence;

    /**
     * @var int Health percentage of the ship
     */
    private $health = 100;

    /**
     * @var WeaponInterface[] list of weapons in the ship
     */
    private $weapons = [];

    /**
     * @param int $attack points of the ship
     * @param int $defence points of the ship
     */
    public function __construct($attack, $defence) {
        $this->attack = $attack;
        $this->defence = $defence;
    }

    /**
     * @return int attack points of the ship
     */
    public function getAttack() {
        return $this->attack;
    }

    /**
     * @return int defence points of the ship
     */
    public function getDefence() {
        return $this->defence;
    }

    /**
     * @return int health percentage of the ship
     */
    public function getHealth() {
        return $this->health;
    }

    /**
     * Updates the health percentage of the ship
     *
     * @param int $health percentage to set the ship to
     */
    public function setHealth($health) {
        $this->health = $health;
    }

    /**
     * Determines if the ship has been sunk (ie health < 1)
     *
     * @return bool true if sunk
     */
    public function isSunk()
    {
        return $this->health < 1;
    }

    /**
     * Adds a weapon to the ship
     *
     * @param WeaponInterface $weapon
     */
    public function addWeapon(WeaponInterface $weapon)
    {
        array_push($this->weapons, $weapon);
    }

    /**
     * Returns list of weapons installed on the ship
     *
     * @return WeaponInterface[] list of weapons on the ship
     */
    public function getWeapons()
    {
        return $this->weapons;
    }

    /**
     * Attacks a target with all weapons on the ship
     *
     * @param AbstractShip $target to attack
     */
    public function attack(AbstractShip $target)
    {
        foreach ($this->weapons as $weapon) {
            $multipler = $weapon->shootAt($target);
            $damage = $this->attack * $multipler;
            if ($damage) {
                $target->damageBy($damage);
            }
        }
    }

    /**
     * Damage the ship by the given amount
     *
     * @param $amount int to reduce the health by
     */
    public function damageBy($amount)
    {
        $this->health -= ( $amount * ( 100 - $this->getDefence() ) ) / 100;
    }
}
