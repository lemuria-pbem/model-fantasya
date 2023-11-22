<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Race;

/**
 * Humans.
 */
final class Human extends AbstractRace
{
	private const int HITPOINTS = 20;

	private const int HUNGER = 6;

	private const float REFILL = 0.25;

	private const int PAYLOAD = 5 * 100;

	private const int RECRUITING = 75;

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
		return [];
	}
}
