<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

use function Lemuria\getClass;
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
	 * @var array(int=>string)
	 */
	private array $herb = [];

	/**
	 * Get a plain data array of the model's data.
	 *
	 * @return int[]
	 */
	#[ArrayShape(['entities' => "array", 'rounds' => "array", 'herbs' => "array"])]
	#[Pure]
	public function serialize(): array {
		$entities = parent::serialize();
		$herbs    = [];
		foreach ($entities['entities'] as $id) {
			$herbs[] = $this->herb[$id];
		}
		$entities['herbs'] = $herbs;
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
		$herbs    = $data['herbs'];
		foreach ($entities as $id) {
			$this->herb[$id] = current($herbs);
			next($herbs);
		}
		return $this;
	}

	/**
	 * Clear the set.
	 */
	public function clear(): EntitySet {
		$this->herb = [];
		return parent::clear();
	}

	public function record(Region $region, Herb $herb): self {
		$id = $region->Id();
		$this->addEntity($id);
		$this->herb[$id->Id()] = getClass($herb);
		return $this;
	}

	public function getHerb(Region $region): ?Herb {
		$class = $this->herb[$region->Id()->Id()] ?? null;
		if ($class) {
			/** @var Herb $herb */
			$herb = self::createCommodity($class);
			return $herb;
		}
		return null;
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
		$this->validate($data, 'herbs', 'array');
	}

	protected function get(Id $id): Entity {
		return Region::get($id);
	}
}
