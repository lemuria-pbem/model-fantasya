<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Race;

use Lemuria\Model\Fantasya\Talent\Alchemy;
use Lemuria\Model\Fantasya\Talent\Armory;
use Lemuria\Model\Fantasya\Talent\Carriagemaking;
use Lemuria\Model\Fantasya\Talent\Constructing;
use Lemuria\Model\Fantasya\Talent\Entertaining;
use Lemuria\Model\Fantasya\Talent\Herballore;
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
	private const int HITPOINTS = 23;

	private const int HUNGER = 7;

	private const float REFILL = 0.18;

	private const int PAYLOAD = 5 * 100;

	private const int RECRUITING = 70;

	private const int WEIGHT = 10 * 100;

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
			Alchemy::class      =>  1, Armory::class        =>  1, Carriagemaking::class => -1,
			Constructing::class =>  1, Entertaining::class  => -2, Herballore::class     => -2,
			Horsetaming::class  => -1, Magic::class         => -1, Mining::class         =>  1,
			Navigation::class   => -1, Quarrying::class     =>  1, Shipbuilding::class   => -1,
			Tactics::class      =>  1, Taxcollecting::class =>  1, Trading::class        => -3,
			Weaponry::class     =>  2, Woodchopping::class  =>  1
		];
	}
}
