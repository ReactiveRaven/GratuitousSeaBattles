<?php

namespace RRaven\GSB\Ship;
use PHPUnit\Framework\TestCase;

class GalleonTest extends TestCase
{
    /**
     * @var Galleon
     */
    private $galleon;

    public function setUp()
    {
        $this->galleon = new Galleon();
    }

    public function testDefaultAttackAsExpected()
    {
        $this->assertEquals(
            10,
            $this->galleon->getAttack(),
            "Default attack should be 10 for a Galleon"
        );
    }

    public function testDefaultDefenceAsExpected()
    {
        $this->assertEquals(
            10,
            $this->galleon->getDefence(),
            "Default defence should be 10 for a Galleon"
        );
    }
}
