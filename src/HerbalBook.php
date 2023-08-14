<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\EntitySet;
use Lemuria\Id;
use Lemuria\Model\Annals;
use Lemuria\Model\Calendar\Moment;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Validate;

/**
 * Each party can record the occurrence of herbs in regions.
 *
 * @method Region offsetGet(int|Id $offset)
 * @method Region current()
 */
class HerbalBook extends Annals
{
	use BuilderTrait;

	private const HERBAGES = 'herbages';

	/**
	 * @var array<int, Herbage>
	 */
	private array $herbage = [];

	/**
	 * Get a plain data array of the model's data.
	 *
	 * @return array<int>
	 */
	public function serialize(): array {
		$entities = parent::serialize();
		$herbages = [];
		foreach ($entities[parent::ENTITIES] as $id) {
			$herbage    = $this->herbage[$id];
			$herbages[] = $herbage?->serialize();
		}
		$entities[self::HERBAGES] = $herbages;
		return $entities;
	}

	/**
	 * Restore the model's data from serialized data.
	 *
	 * @param array<string, array> $data
	 */
	public function unserialize(array $data): static {
		parent::unserialize($data);
		$entities = $data[parent::ENTITIES];
		$herbages = $data[self::HERBAGES];
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

	public function clear(): static {
		$this->herbage = [];
		return parent::clear();
	}

	public function fill(EntitySet $set): static {
		if ($set instanceof HerbalBook) {
			$this->herbage = $set->herbage;
			return parent::fill($set);
		}
		throw new \InvalidArgumentException();
	}

	public function getClone(): static {
		return clone $this;
	}

	public function record(Region $region, ?Herbage $herbage, ?int $round = null): static {
		$id = $region->Id();
		$this->addEntity($id, $round);
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
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		parent::validateSerializedData($data);
		$this->validate($data, self::HERBAGES, Validate::Array);
	}

	protected function get(Id $id): Region {
		return Region::get($id);
	}
}
