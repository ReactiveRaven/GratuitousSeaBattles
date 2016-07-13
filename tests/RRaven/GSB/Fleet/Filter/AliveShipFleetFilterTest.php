<?php


namespace RRaven\GSB\Fleet\Filter;


use PHPUnit\Framework\TestCase;
use RRaven\GSB\Container;
use RRaven\GSB\Ship\AbstractShip;
use RRaven\GSB\Ship\Galleon;
use ArrayIterator;

class AliveShipFleetFilterTest extends TestCase
{
    /**
     * @var AbstractShip[]
     */
    private $shipsArray;
    /**
     * @var AliveShipFleetFilter
     */
    private $filter;
    /**
     * @var AbstractShip
     */
    private $liveShip;
    /**
     * @var AbstractShip
     */
    private $deadShip;

    public function setUp()
    {
        $container = Container::getInstance();

        $this->liveShip = $container->make(Galleon::class);
        $this->deadShip = $container->make(Galleon::class);
        $this->deadShip->setHealth(0);

        $this->shipsArray = [];
        array_push($this->shipsArray, $this->deadShip);
        array_push($this->shipsArray, $this->liveShip);

        $this->filter = new AliveShipFleetFilter(new ArrayIterator($this->shipsArray));
    }

    public function testRejectsDeadShips()
    {
        $count = 0;

        $this->assertEquals(100, $this->liveShip->getHealth());

        foreach ($this->filter as $ship) {
            $count += 1;
            $this->assertNotEquals($this->deadShip, $ship, "Should not return dead ships");
        }

        $this->assertEquals(1, $count, "Should find one live ship");
    }
}
