<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\SingletonSet;

interface Monster extends Protection, Race, TrophySource
{
	/**
	 * Get the native weapon.
	 */
	public function Weapon(): ?Weapon;

	/**
	 * Get the items that this monster takes from loot.
	 */
	public function Loot(): SingletonSet;

	/**
	 * Get the health recreation factor.
	 */
	public function Recreation(): float;

	/**
	 * Get the living environment.
	 *
	 * @return array<Landscape>
	 */
	public function Environment(): array;
}
