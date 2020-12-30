<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Race;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Lemuria\Talent\Archery;
use Lemuria\Model\Lemuria\Talent\Armory;
use Lemuria\Model\Lemuria\Talent\Bladefighting;
use Lemuria\Model\Lemuria\Talent\Camouflage;
use Lemuria\Model\Lemuria\Talent\Catapulting;
use Lemuria\Model\Lemuria\Talent\Constructing;
use Lemuria\Model\Lemuria\Talent\Entertaining;
use Lemuria\Model\Lemuria\Talent\Horsetaming;
use Lemuria\Model\Lemuria\Talent\Mining;
use Lemuria\Model\Lemuria\Talent\Navigation;
use Lemuria\Model\Lemuria\Talent\Perception;
use Lemuria\Model\Lemuria\Talent\Quarrying;
use Lemuria\Model\Lemuria\Talent\Riding;
use Lemuria\Model\Lemuria\Talent\Roadmaking;
use Lemuria\Model\Lemuria\Talent\Shipbuilding;
use Lemuria\Model\Lemuria\Talent\Tactics;
use Lemuria\Model\Lemuria\Talent\Taxcollecting;

/**
 * Trolls are heavy creatures.
 */
final class Troll extends AbstractRace
{
	private const HITPOINTS = 30;

	private const PAYLOAD = 10 * 100;

	private const RECRUITING = 90;

	private const WEIGHT = 20 * 100;

	#[Pure] public function Hitpoints(): int {
		return self::HITPOINTS;
	}

	#[Pure] public function Payload(): int {
		return self::PAYLOAD;
	}

	#[Pure] public function Recruiting(): int {
		return self::RECRUITING;
	}

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	#[Pure] protected function mods(): array {
		return [
			Archery::class      => -2, Armory::class        =>  2, Bladefighting::class =>  1,
			Camouflage::class   => -3, Catapulting::class   =>  2, Constructing::class  =>  2,
			Entertaining::class => -1, Horsetaming::class   => -1, Mining::class        =>  2,
			Navigation::class   => -1, Perception::class    => -1, Quarrying::class     =>  2,
			Riding::class       => -2, Roadmaking::class    =>  2, Shipbuilding::class  => -1,
			Tactics::class      => -1, Taxcollecting::class =>  1
		];
	}
}
