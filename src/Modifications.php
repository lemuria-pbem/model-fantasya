<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Item;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Singleton;

/**
 * @method Modification offsetGet(Singleton|string $offset)
 * @method Modification current()
 * @method Modifications add(Modification $modification)
 * @method Modifications remove(Modification $modification)
 */
class Modifications extends Knowledge
{
	use BuilderTrait;

	/**
	 * Create an Item from unserialized data.
	 */
	protected function createItem(string $class, int $count): Item {
		return new Modification(self::createTalent($class), $count);
	}

	/**
	 * Check if an item is valid for this set.
	 */
		protected function isValidItem(Item $item): bool {
		return $item instanceof Modification;
	}
}
