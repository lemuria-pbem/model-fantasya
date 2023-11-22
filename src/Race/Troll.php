<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Race;

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
	private const int HITPOINTS = 30;

	private const int HUNGER = 12;

	private const float REFILL = 0.15;

	private const int PAYLOAD = 10 * 100;

	private const int RECRUITING = 90;

	private const int WEIGHT = 20 * 100;

	public function Hitpoints(): int {
		return self::HITPOINTS;
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
			Archery::class      => -2, Armory::class      =>  2, Bladefighting::class =>  1,
			Camouflage::class   => -3, Catapulting::class =>  2, Constructing::class  =>  2,
			Entertaining::class => -1, Herballore::class  => -1, Horsetaming::class   => -1,
			Mining::class       =>  2, Navigation::class  => -1, Perception::class    => -1,
			Quarrying::class    =>  2, Riding::class      => -2, Roadmaking::class    =>  2,
			Shipbuilding::class => -1, Tactics::class     => -1, Taxcollecting::class =>  1
		];
	}
}
