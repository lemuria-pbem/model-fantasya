<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Pure;

interface Monster extends Protection, Race
{
	/**
	 * Get the native weapon.
	 */
	#[Pure] public function Weapon(): ?Weapon;

	/**
	 * Get the trophy that can be gained in combat against this monster.
	 */
	#[Pure] public function Trophy(): ?Trophy;

	/**
	 * Get the living environment.
	 *
	 * @return Landscape[]
	 */
	public function Environment(): array;
}
