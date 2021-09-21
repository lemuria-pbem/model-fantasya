<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Race;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Talent\Archery;
use Lemuria\Model\Fantasya\Talent\Armory;
use Lemuria\Model\Fantasya\Talent\Bladefighting;
use Lemuria\Model\Fantasya\Talent\Camouflage;
use Lemuria\Model\Fantasya\Talent\Catapulting;
use Lemuria\Model\Fantasya\Talent\Constructing;
use Lemuria\Model\Fantasya\Talent\Entertaining;
use Lemuria\Model\Fantasya\Talent\Herballore;
use Lemuria\Model\Fantasya\Talent\Horsetaming;
use Lemuria\Model\Fantasya\Talent\Mining;
use Lemuria\Model\Fantasya\Talent\Navigation;
use Lemuria\Model\Fantasya\Talent\Perception;
use Lemuria\Model\Fantasya\Talent\Quarrying;
use Lemuria\Model\Fantasya\Talent\Riding;
use Lemuria\Model\Fantasya\Talent\Roadmaking;
use Lemuria\Model\Fantasya\Talent\Shipbuilding;
use Lemuria\Model\Fantasya\Talent\Tactics;
use Lemuria\Model\Fantasya\Talent\Taxcollecting;

/**
 * Trolls are heavy creatures.
 */
final class Troll extends AbstractRace
{
	private const HITPOINTS = 30;

	private const HUNGER = 12;

	private const REFILL = 0.15;

	private const PAYLOAD = 10 * 100;

	private const RECRUITING = 90;

	private const WEIGHT = 20 * 100;

	#[Pure] public function Hitpoints(): int {
		return self::HITPOINTS;
	}

	#[Pure] public function Hunger(): int {
		return self::HUNGER;
	}

	#[Pure] public function Refill(): float {
		return self::REFILL;
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
			Archery::class      => -2, Armory::class      =>  2, Bladefighting::class =>  1,
			Camouflage::class   => -3, Catapulting::class =>  2, Constructing::class  =>  2,
			Entertaining::class => -1, Herballore::class  => -1, Horsetaming::class   => -1,
			Mining::class       =>  2, Navigation::class  => -1, Perception::class    => -1,
			Quarrying::class    =>  2, Riding::class      => -2, Roadmaking::class    =>  2,
			Shipbuilding::class => -1, Tactics::class     => -1, Taxcollecting::class =>  1
		];
	}
}
