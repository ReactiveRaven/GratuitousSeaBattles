<?php

namespace RRaven\GSB\Ship;
use PHPUnit\Framework\TestCase;
use RRaven\GSB\Container;
use RRaven\GSB\Weapon\Cannon;

class AbstractShipTest extends TestCase
{
    /**
     * @var AbstractShip
     */
    private $ship;

    /**
     * @var Cannon
     */
    private $cannon;

    public function setUp() {
        $this->ship = $this->getMockForAbstractClass(AbstractShip::class, [1, 1]);

        $this->cannon = Container::getInstance()->make(Cannon::class);
    }

    public function testInitiallyFullHealth() {
        $this->assertEquals(
            100,
            $this->ship->getHealth(),
            "Should start at 100 health"
        );
    }

    public function testHealthNotShared() {
        $shipA = $this->ship;
        /**
         * @var AbstractShip $shipB
         */
        $shipB = $this->getMockForAbstractClass(AbstractShip::class, [1, 1]);
        $shipA->setHealth(25);
        $shipB->setHealth(50);

        $this->assertNotEquals(
            $shipA->getHealth(),
            $shipB->getHealth(),
            "Health should not be shared between instances of ships"
        );
    }

    public function testIsSunk()
    {
        $this->ship->setHealth(0);

        $this->assertEquals(true, $this->ship->isSunk(), "When health drops below 1, ship is Sunk");
    }

    public function testCanAddWeapons()
    {
        $this->assertEquals(
            0,
            count($this->ship->getWeapons()),
            "Should start off without weapons"
        );

        $this->ship->addWeapon($this->cannon);

        $this->assertEquals(
            1,
            count($this->ship->getWeapons()),
            "Should have a weapon after installing one"
        );
    }

    public function testCanAttack()
    {
        $this->cannon = $this->createMock(Cannon::class);
        $this->cannon->method("shootAt")->willReturn(1);

        $this->ship->addWeapon($this->cannon);
        $this->ship->setHealth(100);

        $this->ship->attack($this->ship);

        $this->assertLessThan(100, $this->ship->getHealth(), "Should have suffered damage");
    }

    public function testCannotAttackWithoutWeapons()
    {
        $this->assertEquals(0, count($this->ship->getWeapons()), "Should have no weapons");
        $this->ship->setHealth(100);

        $this->ship->attack($this->ship);

        $this->assertEquals(100, $this->ship->getHealth(), "Should have suffered damage");
    }

    public function testCanTakeDamage()
    {
        $damage = 10;
        $defence = $this->ship->getDefence();
        $this->ship->setHealth(100);
        $this->ship->damageBy($damage);
        $this->assertLessThan(100, $this->ship->getHealth(), "Should have been damaged");
        $damageAfterResistance = ( $damage * ( 100 - $defence ) ) / 100;
        $this->assertEquals(
            100 - $damageAfterResistance,
            $this->ship->getHealth(),
            "Damage should be reduced by defence percent"
        );
    }
}
