<?php

namespace RRaven\GSB\Fleet\Filter;

use FilterIterator;
use RRaven\GSB\Ship\AbstractShip;

/**
 * Class AliveShipFleetFilter
 * Used to restrict to only live ships in fleets
 *
 * @package RRaven\GSB\Fleet\Filter
 */
class AliveShipFleetFilter extends FilterIterator
{
    public function accept()
    {
        $current = $this->getInnerIterator()->current();

        return (
            $current instanceof AbstractShip &&
            !$current->isSunk()
        );
    }
}
