<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Race;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Talent\Armory;
use Lemuria\Model\Fantasya\Talent\Carriagemaking;
use Lemuria\Model\Fantasya\Talent\Constructing;
use Lemuria\Model\Fantasya\Talent\Entertaining;
use Lemuria\Model\Fantasya\Talent\Horsetaming;
use Lemuria\Model\Fantasya\Talent\Magic;
use Lemuria\Model\Fantasya\Talent\Mining;
use Lemuria\Model\Fantasya\Talent\Navigation;
use Lemuria\Model\Fantasya\Talent\Quarrying;
use Lemuria\Model\Fantasya\Talent\Shipbuilding;
use Lemuria\Model\Fantasya\Talent\Tactics;
use Lemuria\Model\Fantasya\Talent\Taxcollecting;
use Lemuria\Model\Fantasya\Talent\Trading;
use Lemuria\Model\Fantasya\Talent\Weaponry;
use Lemuria\Model\Fantasya\Talent\Woodchopping;

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
