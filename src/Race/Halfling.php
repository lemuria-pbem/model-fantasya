<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Race;

use Lemuria\Model\Fantasya\Talent\Archery;
use Lemuria\Model\Fantasya\Talent\Bladefighting;
use Lemuria\Model\Fantasya\Talent\Camouflage;
use Lemuria\Model\Fantasya\Talent\Carriagemaking;
use Lemuria\Model\Fantasya\Talent\Catapulting;
use Lemuria\Model\Fantasya\Talent\Constructing;
use Lemuria\Model\Fantasya\Talent\Crossbowing;
use Lemuria\Model\Fantasya\Talent\Entertaining;
use Lemuria\Model\Fantasya\Talent\Herballore;
use Lemuria\Model\Fantasya\Talent\Horsetaming;
use Lemuria\Model\Fantasya\Talent\Mining;
use Lemuria\Model\Fantasya\Talent\Navigation;
use Lemuria\Model\Fantasya\Talent\Perception;
use Lemuria\Model\Fantasya\Talent\Riding;
use Lemuria\Model\Fantasya\Talent\Roadmaking;
use Lemuria\Model\Fantasya\Talent\Shipbuilding;
use Lemuria\Model\Fantasya\Talent\Spearfighting;
use Lemuria\Model\Fantasya\Talent\Taxcollecting;
use Lemuria\Model\Fantasya\Talent\Trading;

/**
 * Halflings are always eating.
 */
final class Halfling extends AbstractRace
{
	private const HITPOINTS = 17;

	private const FLIGHT_CHANCE = 0.5;

	private const HUNGER = 6;

	private const REFILL = 0.2;

	private const PAYLOAD = 5 * 100;

	private const RECRUITING = 60;

	private const WEIGHT = 8 * 100;

	public function Hitpoints(): int {
		return self::HITPOINTS;
	}

	public function FlightChance(): float {
		return self::FLIGHT_CHANCE;
	}

	public function Hunger(): int {
		return self::HUNGER;
	}

	public function Refill(): float {
		return self::REFILL;
	}

	public function Payload(): int {
		return self::PAYLOAD;
	}

	public function Recruiting(): int {
		return self::RECRUITING;
	}

	public function Weight(): int {
		return self::WEIGHT;
	}

	protected function mods(): array {
		return [
			Archery::class        => -1, Bladefighting::class => -1, Camouflage::class    =>  1,
			Carriagemaking::class =>  2, Catapulting::class   => -1, Constructing::class  =>  1,
			Crossbowing::class    =>  1, Entertaining::class  =>  1, Herballore::class    =>  2,
			Horsetaming::class    => -1, Mining::class        =>  1, Navigation::class    => -2,
			Perception::class     =>  1, Riding::class        => -1, Roadmaking::class    =>  1,
			Shipbuilding::class   => -1, Spearfighting::class =>  1, Taxcollecting::class => -1,
			Trading::class        =>  2
		];
	}
}
