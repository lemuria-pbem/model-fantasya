<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Race;

/**
 * Humans.
 */
final class Human extends AbstractRace
{
	private const HITPOINTS = 20;

	private const PAYLOAD = 5 * 100;

	private const RECRUITING = 75;

	private const WEIGHT = 10 * 100;

	/**
	 * Get the hitpoints of a person.
	 *
	 * @return int
	 */
	public function Hitpoints(): int {
		return self::HITPOINTS;
	}

	/**
	 * Get the maximum weight of payload.
	 *
	 * @return int
	 */
	public function Payload(): int {
		return self::PAYLOAD;
	}

	/**
	 * Get the recruiting cost for one person.
	 *
	 * @return int
	 */
	public function Recruiting(): int {
		return self::RECRUITING;
	}

	/**
	 * Get the weight of a person.
	 *
	 * @return int
	 */
	public function Weight(): int {
		return self::WEIGHT;
	}

	/**
	 * Get the modifications.
	 *
	 * @return array(Talent=>int)
	 */
	protected function mods(): array {
		return [];
	}
}
