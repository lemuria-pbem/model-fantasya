<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

interface MagicRing
{
	/**
	 * Get the corresponding spell that is cast to create this ring.
	 */
	public function Enchantment(): Spell;
}
