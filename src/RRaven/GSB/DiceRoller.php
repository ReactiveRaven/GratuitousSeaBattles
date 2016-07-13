<?php


namespace RRaven\GSB;

/**
 * Class DiceRoller
 * Used to generate random numbers and for mocking
 *
 * @package RRaven\GSB
 */
class DiceRoller
{
    /**
     * Generates a random number between the given max and min
     *
     * @param $min int minimum value the dice can roll
     * @param $max int maximum value the dice can roll
     * @return int the rolled number
     */
    public function roll($min = 1, $max = 100) {
        return rand($min, $max);
    }
}
