<?php


namespace RRaven\GSB\Weapon;

use PHPUnit\Framework\TestCase;
use RRaven\GSB\DiceRoller;
use RRaven\GSB\Ship\Galleon;
use PHPUnit_Framework_MockObject_MockObject;

class CannonTest extends TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $roller;
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
        $this->roller = $this->createMock(DiceRoller::class);
        $this->galleon = new Galleon();
        $this->cannon = new Cannon($this->roller);
    }

    public function testReturnsHitMultiplier() {
        $this->assertEquals(
            true,
            is_int($this->cannon->shootAt($this->galleon)),
            "Should return an integer representing whether the shot hit, and was critical"
        );
    }

    public function testMissReturnsZero() {
        $this->roller->method("roll")->will($this->returnArgument(0));

        $this->assertEquals(
            0,
            $this->cannon->shootAt($this->galleon),
            "Should return 0 when the cannon misses"
        );
    }

    public function testCriticalReturnsThree() {
        $this->roller->method("roll")->will($this->returnArgument(1));

        $this->assertEquals(
            3,
            $this->cannon->shootAt($this->galleon),
            "Should return 3 when the cannon critical hits"
        );
    }

    public function testHitReturnsOne() {
        $this->roller->method("roll")->will($this->returnValue(50));

        $this->assertEquals(
            1,
            $this->cannon->shootAt($this->galleon),
            "Should return 1 when the cannon hits with a standard hit"
        );
    }
}
