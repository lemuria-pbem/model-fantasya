<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\EntitySet;
use Lemuria\Id;

/**
 * A collection of regions.
 *
 * @method Region offsetGet(int|Id $offset)
 * @method Region current()
 */
class Landmass extends EntitySet
{
	public function serialize(): array {
		return $this->sortSerialized(parent::serialize());
	}

	public function getClone(): Landmass {
		return clone $this;
	}

	public function add(Region $region): static {
		$this->addEntity($region->Id());
		if ($this->hasCollector()) {
			$region->addCollector($this->collector());
		}
		return $this;
	}

	public function remove(Region $region): static {
		$this->removeEntity($region->Id());
		if ($this->hasCollector()) {
			$region->removeCollector($this->collector());
		}
		return $this;
	}

	protected function get(Id $id): Region {
		return Region::get($id);
	}

	protected function sortSerialized(array $data): array {
		sort($data);
		return $data;
	}
}
