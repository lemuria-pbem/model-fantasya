<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Pure;

use Lemuria\Item;
use Lemuria\ItemSet;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;

/**
 * The knowledge that a unit has represents all talents that it is able to use.
 */
class Knowledge extends ItemSet
{
	use BuilderTrait;

	public function add(Ability $ability): Knowledge {
		$this->addItem($ability);
		return $this;
	}

	public function remove(Ability $ability): Knowledge {
		$this->removeItem($ability);
		return $this;
	}

	/**
	 * Create an Item from unserialized data.
	 */
	protected function createItem(string $class, int $count): Item {
		return new Ability(self::createTalent($class), $count);
	}

	/**
	 * Check if an item is valid for this set.
	 */
	#[Pure]	protected function isValidItem(Item $item): bool {
		return $item instanceof Ability;
	}
}
