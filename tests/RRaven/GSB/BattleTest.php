<?php


namespace RRaven\GSB;

use DI\Container as DIContainer;
use PHPUnit\Framework\TestCase;
use RRaven\GSB\Fleet\Fleet;
use RRaven\GSB\Ship\Galleon;

class BattleTest extends TestCase
{
    /**
     * @var Fleet
     */
    private $attackingFleet;
    /**
     * @var Fleet
     */
    private $defendingFleet;
    /**
     * @var Battle
     */
    private $battle;

    /**
     * @var DIContainer
     */
    private $container;

    public function setUp()
    {
        $this->container = Container::getInstance();

        $this->attackingFleet = $this->container->make(Fleet::class);
        $this->defendingFleet = $this->container->make(Fleet::class);

        $this->battle = new Battle();
        $this->battle->setAttackingFleet($this->attackingFleet);
        $this->battle->setDefendingFleet($this->defendingFleet);
    }

    public function testCanTellWhenBattleIsOver()
    {
        $this->assertTrue($this->battle->isOver(), "Over when no ships");

        /**
         * @var Galleon $attackingShip
         */
        $attackingShip = $this->container->make(Galleon::class);
        $this->attackingFleet->addShip($attackingShip);
        /**
         * @var Galleon $defendingShip
         */
        $defendingShip = $this->container->make(Galleon::class);
        $this->defendingFleet->addShip($defendingShip);

        $this->assertFalse($this->battle->isOver(), "Not over when live ships on both sides");

        $attackingShip->setHealth(0);

        $this->assertTrue($this->battle->isOver(), "Over when one side is defeated");
    }
}
