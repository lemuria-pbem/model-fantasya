<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Composition;

use Lemuria\Model\Fantasya\Spell;
use Lemuria\Model\Fantasya\Spell\RingOfInvisibilitySpell;

class RingOfInvisibility extends AbstractMagicRing
{
	public function Enchantment(): Spell {
		return self::createSpell(RingOfInvisibilitySpell::class);
	}
}
