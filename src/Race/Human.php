<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Race;

use JetBrains\PhpStorm\Pure;

/**
 * Humans.
 */
final class Human extends AbstractRace
{
	private const HITPOINTS = 20;

	private const PAYLOAD = 5 * 100;

	private const RECRUITING = 75;

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
		return [];
	}
}
