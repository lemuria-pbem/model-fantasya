<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Race;

use Lemuria\Model\Fantasya\Talent\Armory;
use Lemuria\Model\Fantasya\Talent\Bladefighting;
use Lemuria\Model\Fantasya\Talent\Carriagemaking;
use Lemuria\Model\Fantasya\Talent\Catapulting;
use Lemuria\Model\Fantasya\Talent\Crossbowing;
use Lemuria\Model\Fantasya\Talent\Horsetaming;
use Lemuria\Model\Fantasya\Talent\Mining;
use Lemuria\Model\Fantasya\Talent\Navigation;
use Lemuria\Model\Fantasya\Talent\Riding;
use Lemuria\Model\Fantasya\Talent\Roadmaking;
use Lemuria\Model\Fantasya\Talent\Shipbuilding;
use Lemuria\Model\Fantasya\Talent\Spearfighting;
use Lemuria\Model\Fantasya\Talent\Trading;
use Lemuria\Model\Fantasya\Talent\Woodchopping;

/**
 * Aquans are humans of the sea.
 */
final class Aquan extends AbstractRace
{
	private const HITPOINTS = 25;

	private const HUNGER = 8;

	private const REFILL = 0.25;

	private const PAYLOAD = 5 * 100;

	private const RECRUITING = 80;

	private const WEIGHT = 10 * 100;

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
			Armory::class      => -2, Bladefighting::class => -1, Carriagemaking::class => -1,
			Catapulting::class => -2, Crossbowing::class   => -1, Horsetaming::class    => -1,
			Mining::class      => -1, Navigation::class    =>  2, Riding::class         => -1,
			Roadmaking::class  => -2, Shipbuilding::class  =>  2, Spearfighting::class  => 1,
			Trading::class     =>  2,  Woodchopping::class =>  1
		];
	}
}
