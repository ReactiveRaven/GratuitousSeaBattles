<?php


namespace RRaven\GSB;


use RRaven\GSB\Fleet\AbstractFleet;
use RRaven\GSB\Ship\AbstractShip;

/**
 * Class Battle
 * Represents a battle between two fleets.
 * Handles turn order and whether the battle has finished.
 *
 * @package RRaven\GSB
 */
class Battle
{
    /**
     * @var AbstractFleet
     */
    private $attackingFleet;

    /**
     * @var AbstractFleet
     */
    private $defendingFleet;

    /**
     * Set the attacking fleet for the battle
     *
     * @param AbstractFleet $fleet
     */
    public function setAttackingFleet(AbstractFleet $fleet)
    {
        $this->attackingFleet = $fleet;
    }

    /**
     * Set the defending fleet for the battle
     *
     * @param AbstractFleet $fleet
     */
    public function setDefendingFleet(AbstractFleet $fleet)
    {
        $this->defendingFleet = $fleet;
    }

    /**
     * Advances the battle by one turn of both attackers and defenders
     */
    public function turn()
    {
        foreach ($this->defendingFleet as $ship) {
            $this->attack($ship, $this->attackingFleet);
        }

        foreach ($this->attackingFleet as $ship) {
            $this->attack($ship, $this->defendingFleet);
        }
    }

    /**
     * Determines whether the battle has ended.
     *
     * @return bool true if the battle is over
     */
    public function isOver()
    {
        return (
            $this->defendingFleet->isDefeated() ||
            $this->attackingFleet->isDefeated()
        );
    }

    /**
     * Get the first non-sunk ship in the fleet, or null if there are no ships left
     *
     * @param AbstractFleet $fleet
     * @return null|AbstractShip
     */
    private function firstAliveShipInFleet(AbstractFleet $fleet)
    {
        foreach ($fleet as $ship) {
            if (!$ship->isSunk()) {
                return $ship;
            }
        }

        return null;
    }

    /**
     * Finds a relevant target for the given ship (if one is available) and tells it to attack.
     *
     * @param AbstractShip $ship
     * @param AbstractFleet $fleet
     */
    private function attack(AbstractShip $ship, AbstractFleet $fleet)
    {
        if (!$ship->isSunk() && ($target = $this->firstAliveShipInFleet($fleet)) ) {
            $ship->attack($target);
        }
    }
}
