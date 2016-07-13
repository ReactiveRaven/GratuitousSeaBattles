<?php

require_once "vendor/autoload.php";

use RRaven\GSB\Ship\Galleon;
use RRaven\GSB\Ship\Frigate;
use RRaven\GSB\Battle;
use RRaven\GSB\Fleet\Fleet;
use RRaven\GSB\Weapon\Cannon;
use RRaven\GSB\Container;

$container = Container::getInstance();

// SET UP FLEETS
$spain = new Fleet();
$numGalleons = 8;
while ($numGalleons-- > 0) {
    $spain->addShip(new Galleon());
}
$spain->armShips($container->make(Cannon::class));

$france = new Fleet();
$numFrigates = 10;
while ($numFrigates-- > 0) {
    $france->addShip(new Frigate());
}
$france->armShips($container->make(Cannon::class));

// SET UP THE BATTLE
$battle = new Battle();
$battle->setAttackingFleet($spain);
$battle->setDefendingFleet($france);

echo "The battle starts with:\n";
echo count($spain) . "  Spanish Galleons\n";
echo count($france) . " French Frigates\n\n";

echo "GALLEONS FRIGATES  - TURN\n";

// FIGHT!
$turns = 0;
const MAX_TURNS = 100;
while (!$battle->isOver() && $turns++ < MAX_TURNS) {
    $spainCasualties = $spain->getCasualties();
    $franceCasualties = $france->getCasualties();

    $battle->turn();

    if ($spain->getCasualties() + $france->getCasualties() - $spainCasualties - $franceCasualties > 0) {
        foreach ($spain as $galleon) {
            if ($galleon->isSunk()) {
                echo "_";
            } else {
                echo "G";
            }
        }
        echo " ";
        $franceString = "";
        foreach ($france as $frigate) {
            if ($frigate->isSunk()) {
                $franceString .= "_";
            } else {
                $franceString .= "F";
            }
        }
        echo strrev($franceString) . " - $turns\n";
    }
}

// AFTER-BATTLE REPORT
if ($battle->isOver()) {
    echo "The battle is over in $turns turns!\n";
    if ($spain->isDefeated()) {
        echo "Spain is defeated\n";
    }
    if ($france->isDefeated()) {
        echo "France is defeated\n";
    }
} else {
    echo "The battle drew on for over " . MAX_TURNS . " turns, with no end in sight.";
}



