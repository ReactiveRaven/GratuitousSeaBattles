<?php


namespace RRaven\GSB\Ship;


class FriggateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Frigate
     */
    private $friggate;

    public function setUp()
    {
        $this->friggate = new Frigate();
    }

    public function testDefaultAttack()
    {
        $this->assertEquals(5, $this->friggate->getAttack(), "Friggates should start at 5 attack");
    }

    public function testDefaultDefence()
    {
        $this->assertEquals(25, $this->friggate->getDefence(), "Friggates defend at 25");
    }
}
