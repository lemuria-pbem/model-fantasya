<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Item;
use Lemuria\ItemSet;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Singleton;

/**
 * A Populations is a set of gangs.
 *
 * @method Gang offsetGet(Singleton|string $offset)
 * @method Gang current()
 */
class Population extends ItemSet
{
	use BuilderTrait;

	public function Size(): int {
		$size = 0;
		foreach ($this as $gang) {
			$size += $gang->Count();
		}
		return $size;
	}

	public function getClone(): static {
		return clone $this;
	}

	public function add(Gang $gang): static {
		$this->addItem($gang);
		return $this;
	}

	public function remove(Gang $gang): static {
		$this->removeItem($gang);
		return $this;
	}

	protected function createItem(string $class, int $count): Item {
		return new Gang(self::createRace($class), $count);
	}

	protected function isValidItem(Item $item): bool {
		return $item instanceof Gang;
	}
}
