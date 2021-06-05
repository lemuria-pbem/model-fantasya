<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Race;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Talent\Alchemy;
use Lemuria\Model\Fantasya\Talent\Archery;
use Lemuria\Model\Fantasya\Talent\Armory;
use Lemuria\Model\Fantasya\Talent\Bowmaking;
use Lemuria\Model\Fantasya\Talent\Camouflage;
use Lemuria\Model\Fantasya\Talent\Catapulting;
use Lemuria\Model\Fantasya\Talent\Constructing;
use Lemuria\Model\Fantasya\Talent\Herballore;
use Lemuria\Model\Fantasya\Talent\Horsetaming;
use Lemuria\Model\Fantasya\Talent\Magic;
use Lemuria\Model\Fantasya\Talent\Mining;
use Lemuria\Model\Fantasya\Talent\Navigation;
use Lemuria\Model\Fantasya\Talent\Perception;
use Lemuria\Model\Fantasya\Talent\Quarrying;
use Lemuria\Model\Fantasya\Talent\Roadmaking;
use Lemuria\Model\Fantasya\Talent\Shipbuilding;

/**
 * Elves live in the woods.
 */
final class Elf extends AbstractRace
{
	private const HITPOINTS = 22;

	private const PAYLOAD = 5 * 100;

	private const RECRUITING = 130;

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
			Alchemy::class      => -1, Archery::class    =>  2, Armory::class      => -1,
			Bowmaking::class    =>  2, Camouflage::class =>  1, Catapulting::class => -2,
			Constructing::class => -1, Herballore::class =>  2, Horsetaming::class =>  1,
			Magic::class        =>  1, Mining::class     => -2, Navigation::class  => -1,
			Perception::class   =>  1, Quarrying::class  => -1, Roadmaking::class  => -1,
			Shipbuilding::class => -1
		];
	}
}
