<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

/**
 * Shields and Armors must implement this interface.
 */
interface Protection
{
	/**
	 * Get the protection value to reduce damage in combat.
	 */
	public function Block(): int;
}
