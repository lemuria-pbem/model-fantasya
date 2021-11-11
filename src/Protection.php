<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Pure;

/**
 * Shields and Armors must implement this interface.
 */
interface Protection
{
	/**
	 * Get the protection value to reduce damage in combat.
	 */
	#[Pure] public function Block(): int;
}
