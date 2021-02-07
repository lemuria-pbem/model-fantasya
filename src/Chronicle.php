<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use Lemuria\Entity;
use Lemuria\Id;
use Lemuria\Model\Annals;
use Lemuria\Model\Calendar\Moment;

/**
 * Each party has a chronicle of visited regions.
 */
class Chronicle extends Annals
{
	public function add(Region $region): self {
		$this->addEntity($region->Id());
		return $this;
	}

	public function getVisit(Region $region): ?Moment {
		$id = $region->Id();
		if ($this->has($id)) {
			return new Moment($this->getRound($id->Id()));
		}
		return null;
	}

	protected function get(Id $id): Entity {
		return Region::get($id);
	}
}
