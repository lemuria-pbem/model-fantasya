<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\EntitySet;
use Lemuria\Serializable;
use Lemuria\Entity;
use Lemuria\Id;
use Lemuria\Model\Annals;
use Lemuria\Model\Calendar\Moment;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;

/**
 * Each party can record the occurrence of herbs in regions.
 */
class HerbalBook extends Annals
{
	use BuilderTrait;

	/**
	 * @var array<int, Herbage>
	 */
	private array $herbage = [];

	/**
	 * Get a plain data array of the model's data.
	 *
	 * @return int[]
	 */
	public function serialize(): array {
		$entities = parent::serialize();
		$herbages = [];
		foreach ($entities['entities'] as $id) {
			$herbage    = $this->herbage[$id];
			$herbages[] = $herbage?->serialize();
		}
		$entities['herbages'] = $herbages;
		return $entities;
	}

	/**
	 * Restore the model's data from serialized data.
	 *
	 * @param array(array) $data
	 */
	public function unserialize(array $data): Serializable {
		parent::unserialize($data);
		$entities = $data['entities'];
		$herbages = $data['herbages'];
		foreach ($entities as $id) {
			$herb = current($herbages);
			if ($herb) {
				$herbage            = new Herbage();
				$this->herbage[$id] = $herbage->unserialize($herb);
			} else {
				$this->herbage[$id] = null;
			}
			next($herbages);
		}
		return $this;
	}

	/**
	 * Clear the set.
	 */
	public function clear(): EntitySet {
		$this->herbage = [];
		return parent::clear();
	}

	public function record(Region $region, ?Herbage $herbage): self {
		$id = $region->Id();
		$this->addEntity($id);
		$this->herbage[$id->Id()] = $herbage;
		return $this;
	}

	public function getHerbage(Region $region): ?Herbage {
		return $this->herbage[$region->Id()->Id()] ?? null;
	}

	public function getVisit(Region $region): ?Moment {
		$id = $region->Id();
		if ($this->has($id)) {
			return new Moment($this->getRound($id->Id()));
		}
		return null;
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array(string=>mixed) $data
	 */
	protected function validateSerializedData(array &$data): void {
		parent::validateSerializedData($data);
		$this->validate($data, 'herbages', 'array');
	}

	protected function get(Id $id): Entity {
		return Region::get($id);
	}
}
