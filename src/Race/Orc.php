<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Race;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Lemuria\Talent\Armory;
use Lemuria\Model\Lemuria\Talent\Carriagemaking;
use Lemuria\Model\Lemuria\Talent\Constructing;
use Lemuria\Model\Lemuria\Talent\Entertaining;
use Lemuria\Model\Lemuria\Talent\Horsetaming;
use Lemuria\Model\Lemuria\Talent\Magic;
use Lemuria\Model\Lemuria\Talent\Mining;
use Lemuria\Model\Lemuria\Talent\Navigation;
use Lemuria\Model\Lemuria\Talent\Quarrying;
use Lemuria\Model\Lemuria\Talent\Shipbuilding;
use Lemuria\Model\Lemuria\Talent\Tactics;
use Lemuria\Model\Lemuria\Talent\Taxcollecting;
use Lemuria\Model\Lemuria\Talent\Trading;
use Lemuria\Model\Lemuria\Talent\Weaponry;
use Lemuria\Model\Lemuria\Talent\Woodchopping;

/**
 * Orcs are always in war.
 */
final class Orc extends AbstractRace
{
	private const HITPOINTS = 23;

	private const PAYLOAD = 5 * 100;

	private const RECRUITING = 70;

	private const WEIGHT = 10 * 100;

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
			Armory::class       =>  1, Carriagemaking::class => -1, Constructing::class  =>  1,
			Entertaining::class => -2, Horsetaming::class    => -1, Magic::class         => -1,
			Mining::class       =>  1, Navigation::class     => -1, Quarrying::class     =>  1,
			Shipbuilding::class => -1, Tactics::class        => 1 , Taxcollecting::class =>  1,
			Trading::class      => -3, Weaponry::class       =>  2, Woodchopping::class  =>  1
		];
	}
}
