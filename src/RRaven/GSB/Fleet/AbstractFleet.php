<?php


namespace RRaven\GSB\Fleet;

use ArrayAccess;
use Countable;
use Iterator;
use RRaven\GSB\Fleet\Filter\AliveShipFleetFilter;
use RRaven\GSB\Ship\AbstractShip;

/**
 * Class AbstractFleet
 * Abstract class for fleets, to allow extensions later and also concrete helper functions.
 *
 * @package RRaven\GSB\Fleet
 */
abstract class AbstractFleet implements Iterator, ArrayAccess, Countable
{
    /**
     * @var AbstractShip[] list of ships in the fleet
     */
    protected $ships = [];
    private $index = 0;

    /**
     * Utility function to get the live-iterator
     *
     * @return AliveShipFleetFilter
     */
    private function liveShipIterator()
    {
        return new AliveShipFleetFilter($this);
    }

    /**
     * Adds a new ship to the fleet
     *
     * @param AbstractShip $ship
     */
    public function addShip(AbstractShip $ship) {
        array_push($this->ships, $ship);
    }

    /**
     * Determines if the fleet has been defeated
     *
     * @return bool true if the fleet is defeated
     */
    public function isDefeated()
    {
        foreach ($this->ships as $ship) {
            if (!$ship->isSunk()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Returns the first live ship in the fleet
     *
     * @return null|AbstractShip
     */
    public function getFirstLiveShip()
    {
        foreach ($this->liveShipIterator() as $aliveShip) {
            return $aliveShip;
        }

        return null;
    }

    /**
     * Adds the given weapon to every ship in the fleet
     *
     * @param $weapon
     */
    public function armShips($weapon)
    {
        foreach ($this->ships as $ship) {
            $ship->addWeapon($weapon);
        }
    }

    /**
     * Returns the number of casualties suffered so far by the fleet
     *
     * @return int number of casualties suffered
     */
    public function getCasualties()
    {
        $liveShips = 0;
        foreach ($this->liveShipIterator() as $_) {
            $liveShips++;
        }

        return count($this) - $liveShips;
    }

    /* BELOW IS INTERFACE METHODS --------------------------------------------------------------- */

    /**
     * Rewind the iterator
     */
    public function rewind() {
        $this->index = 0;
    }

    /**
     * Get the current item pointed to by the iterator
     *
     * @return AbstractShip
     */
    public function current()
    {
        return $this->ships[$this->index];
    }

    /**
     * Get the key of the current item in the iterator
     *
     * @return int
     */
    public function key() {
        return $this->index;
    }

    /**
     * Shift the iterator's pointer to the next item
     */
    public function next() {
        ++$this->index;
    }

    /**
     * Determine if the current location of the iterator is valid
     *
     * @return bool
     */
    public function valid() {
        return isset($this->ships[$this->index]);
    }

    /**
     * Determine if the requested key is available in the array
     *
     * @param int $offset
     * @return bool
     */
    public function offsetExists($offset) {
        return isset($this->ships[$offset]);
    }

    /**
     * Retrieve the value at the given offset in the array
     *
     * @param int $offset
     * @return AbstractShip
     */
    public function offsetGet($offset) {
        return $this->ships[$offset];
    }

    /**
     * Update the value at the given offset in the array
     *
     * @param int $offset
     * @param AbstractShip $value
     */
    public function offsetSet($offset, $value)
    {
        $this->ships[$offset] = $value;
    }

    /**
     * Remove the item at the given offset in the array
     *
     * @param int $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->ships[$offset]);
    }

    /**
     * Count the number of items in the object
     *
     * @return int
     */
    public function count() {
        return count($this->ships);
    }

    /* ABOVE ARE INTERFACE METHODS -------------------------------------------------------------- */
}
