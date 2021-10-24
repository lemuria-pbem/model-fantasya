<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use JetBrains\PhpStorm\Pure;

final class Ent extends AbstractMonster
{
	private const BLOCK = 3;

	private const HITPOINTS = 450;

	private const PAYLOAD = 100 * 100;

	private const WEIGHT = 240 * 100;

	#[Pure] public function Block(): int {
		return self::BLOCK;
	}

	#[Pure] public function Hitpoints(): int {
		return self::HITPOINTS;
	}

	#[Pure] public function Payload(): int {
		return self::PAYLOAD;
	}

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}
}
