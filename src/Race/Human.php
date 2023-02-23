<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Race;

/**
 * Humans.
 */
final class Human extends AbstractRace
{
	private const HITPOINTS = 20;

	private const HUNGER = 6;

	private const REFILL = 0.25;

	private const PAYLOAD = 5 * 100;

	private const RECRUITING = 75;

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
		return [];
	}
}
