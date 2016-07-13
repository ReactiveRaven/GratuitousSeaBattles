<?php


namespace RRaven\GSB\Fleet;

use PHPUnit\Framework\TestCase;
use RRaven\GSB\Container;
use RRaven\GSB\Ship\Galleon;
use RRaven\GSB\Weapon\Cannon;


class AbstractFleetTest extends TestCase
{
    /**
     * @var AbstractFleet
     */
    private $fleet;

    /**
     * @var Galleon
     */
    private $galleon;

    /**
     * @var Cannon
     */
    private $cannon;

    public function setUp()
    {
        $this->fleet = $this->getMockForAbstractClass(AbstractFleet::class);
        $container = Container::getInstance();
        $this->galleon = $container->make(Galleon::class);
        $this->cannon = $container->make(Cannon::class);
    }

    public function testIsDefeated()
    {
        $this->assertTrue($this->fleet->isDefeated(), "Defeated when no ships");

        $this->fleet->addShip($this->galleon);
        $this->galleon->setHealth(0);

        $this->assertTrue($this->fleet->isDefeated(), "Defeated if no live ships");

        $this->galleon->setHealth(100);

        $this->assertFalse($this->fleet->isDefeated(), "Not defeated if a live ship is left");
    }

    public function testGetFirstLiveShip()
    {
        $this->assertNull($this->fleet->getFirstLiveShip(), "If no ships, returns null");

        $this->fleet->addShip($this->galleon);

        $this->assertEquals(
            $this->galleon,
            $this->fleet->getFirstLiveShip(),
            "Returns first live ship"
        );

        $this->galleon->setHealth(0);

        $this->assertNull($this->fleet->getFirstLiveShip(), "If no live ships, returns null");
    }

    public function testArmShips()
    {
        $this->assertEmpty($this->galleon->getWeapons(), "Should be unarmed initially");

        $this->fleet->addShip($this->galleon);

        $this->fleet->armShips($this->cannon);

        $this->assertNotEmpty($this->galleon->getWeapons(), "Should be armed via the fleet");
    }

    public function testNumberOfCasualties()
    {
        $this->assertEquals(0, $this->fleet->getCasualties(), "No casualties with no ships");

        $this->fleet->addShip($this->galleon);

        $this->assertEquals(0, $this->fleet->getCasualties(), "No casualties with no sunk ships");

        $this->galleon->setHealth(0);

        $this->assertEquals(1, $this->fleet->getCasualties(), "One casualty when one sunk");
    }
}
