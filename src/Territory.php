<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\EntitySet;
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

	public function clear(): EntitySet {
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
}
