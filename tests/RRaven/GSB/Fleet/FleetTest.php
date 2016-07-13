<?php


namespace RRaven\GSB\Fleet;

use PHPUnit\Framework\TestCase;
use RRaven\GSB\Ship\Galleon;
use RRaven\GSB\Container;

class FleetTest extends TestCase
{
    /**
     * @var Fleet
     */
    private $fleet;
    /**
     * @var Galleon
     */
    private $galleon;

    public function setUp()
    {
        $this->fleet = new Fleet();
        $this->galleon = Container::getInstance()->make(Galleon::class);
    }

    public function testCanAddShips()
    {
        $this->assertEquals(0, count($this->fleet), "Should start empty");
        $this->fleet->addShip($this->galleon);
        $this->assertEquals(1, count($this->fleet), "Added one ship, should have count of 1");
    }

    public function testCanIterateShips()
    {
        $this->fleet->addShip($this->galleon);

        $count = 0;

        foreach ($this->fleet as $ship) {
            if ($ship === $this->galleon) {
                $count++;
            }
        }

        $this->assertEquals(1, $count, "Should be able to iterate over ships in fleet");
    }

    public function testCanAccessShips()
    {
        $this->fleet->addShip($this->galleon);

        $this->assertEquals(
            $this->galleon,
            $this->fleet[0],
            "Should be able to access ships by index"
        );
    }
}
