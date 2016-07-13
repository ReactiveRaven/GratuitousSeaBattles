<?php


namespace RRaven\GSB;


class DiceRollerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DiceRoller
     */
    private $roller;

    public function setUp() {
        $this->roller = new DiceRoller();
    }

    public function testRollsWithinGivenNumbers() {
        $min = 1;
        $max = 100;
        $roll = $this->roller->roll($min,$max);

        $this->assertGreaterThanOrEqual($min, $roll);
        $this->assertLessThanOrEqual($max, $roll);
    }

    public function testReturnsIntegers() {
        for ($i = 0; $i < 10; $i++) {
            $roll = $this->roller->roll(0, 1);
            $this->assertEquals(true, is_int($roll), "Should return an integer");
        }
    }
}
