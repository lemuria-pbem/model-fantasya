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
use Lemuria\Model\Lemuria\Talent\Magic;
use Lemuria\Model\Lemuria\Talent\Mining;
use Lemuria\Model\Lemuria\Talent\Navigation;
use Lemuria\Model\Lemuria\Talent\Quarrying;
use Lemuria\Model\Lemuria\Talent\Riding;
use Lemuria\Model\Lemuria\Talent\Roadmaking;
use Lemuria\Model\Lemuria\Talent\Shipbuilding;
use Lemuria\Model\Lemuria\Talent\Taxcollecting;
use Lemuria\Model\Lemuria\Talent\Trading;
use Lemuria\Model\Lemuria\Talent\Weaponry;
use Lemuria\Model\Lemuria\Talent\Woodchopping;

/**
 * Dwarfs live in the mountains.
 */
final class Dwarf extends AbstractRace
{
	private const HITPOINTS = 25;

	private const PAYLOAD = 5 * 100;

	private const RECRUITING = 110;

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
			Archery::class       => -1, Armory::class      =>  2, Bladefighting::class =>  1,
			Camouflage::class    => -1, Catapulting::class =>  2, Constructing::class  =>  2,
			Entertaining::class  => -1, Horsetaming::class => -2, Magic::class         => -2,
			Mining::class        =>  2, Navigation::class  => -2, Quarrying::class     =>  2,
			Riding::class        => -2, Roadmaking::class  =>  2, Shipbuilding::class  => -1,
			Taxcollecting::class =>  1, Trading::class     =>  1, Weaponry::class      =>  2,
			Woodchopping::class  => -1
		];
	}
}
