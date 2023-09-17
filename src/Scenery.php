<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Item;
use Lemuria\ItemSet;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Singleton;

/**
 * Sceneries are sets of scenes.
 *
 * @method Scene offsetGet(Singleton|string $offset)
 * @method Scene current()
 */
class Scenery extends ItemSet
{
	use BuilderTrait;

	public function Size(): int {
		$size = 0;
		foreach ($this as $scene) {
			$size += $scene->Count();
		}
		return $size;
	}

	public function getClone(): static {
		return clone $this;
	}

	public function add(Scene $scene): static {
		$this->addItem($scene);
		return $this;
	}

	public function remove(Scene $scene): static {
		$this->removeItem($scene);
		return $this;
	}

	protected function createItem(string $class, int $count): Item {
		return new Scene(self::createLandscape($class), $count);
	}

	protected function isValidItem(Item $item): bool {
		return $item instanceof Scene;
	}
}
