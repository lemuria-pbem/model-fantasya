<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Item;

/**
 * An enchantment is a helper object for cast spells.
 */
class Enchantment extends Item
{
	public function __construct(Spell $spell, int $count = 1) {
		parent::__construct($spell, $count);
	}

	public function Spell(): Spell {
		/** @var Spell $spell */
		$spell = $this->getObject();
		return $spell;
	}

	public function add(Enchantment $enchantment): static {
		$this->addItem($enchantment);

		return $this;
	}

	public function remove(Enchantment $enchantment): static {
		$this->removeItem($enchantment);

		return $this;
	}
}
