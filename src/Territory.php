<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Id;

/**
 * A collection of regions that have a central.
 */
class Territory extends Landmass
{
	private ?Id $central = null;

	public function Central(): ?Region {
		if (!$this->central) {
			$this->central = $this->first();
		}
		return $this->central ? $this->get($this->central) : null;
	}

	public function clear(): static {
		parent::clear();
		$this->central = null;
		return $this;
	}

	protected function removeEntity(Id $id): void {
		parent::removeEntity($id);
		if ($this->count() <= 0 || $this->central && $this->central->Id() === $id->Id()) {
			$this->central = null;
		}
	}

	protected function sortSerialized(array $data): array {
		$central = array_shift($data);
		sort($data);
		array_unshift($data, $central);
		return $data;
	}
}
