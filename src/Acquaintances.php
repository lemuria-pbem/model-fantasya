<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

use Lemuria\EntitySet;
use Lemuria\Exception\UnserializeException;
use Lemuria\Id;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;

/**
 * The people of a player or party is the community of all its units.
 */
class Acquaintances extends Gathering
{
	use SerializableTrait;

	/**
	 * @var array(int=>bool)
	 */
	private array $isTold = [];

	/**
	 * Get a plain data array of the model's data.
	 *
	 * @return int[]
	 */
	#[ArrayShape(['entities' => "array", 'isTold' => "array"])]
	#[Pure]
	public function serialize(): array {
		$entities = [];
		$isTold   = [];
		foreach ($this->isTold as $id => $told) {
			$entities[] = $id;
			$isTold[]   = $told;
		}
		return ['entities' => $entities, 'isTold' => $isTold];
	}

	/**
	 * Restore the model's data from serialized data.
	 *
	 * @param array(array) $data
	 */
	public function unserialize(array $data): Serializable {
		$this->validateSerializedData($data);
		if ($this->count() > 0) {
			$this->clear();
		}

		$entities = array_values($data['entities']);
		$isTold   = array_values($data['isTold']);
		$n        = count($entities);
		if (count($isTold) !== $n) {
			throw new UnserializeException('Mismatch of entities and rounds count.');
		}

		for ($i = 0; $i < $n; $i++) {
			$this->addEntity(new Id($entities[$i]), $isTold[$i]);
		}
		return $this;
	}

	/**
	 * Clear the set.
	 */
	public function clear(): EntitySet {
		$this->isTold = [];
		return parent::clear();
	}

	public function add(Party $party): Acquaintances {
		return parent::add($party);
	}

	public function remove(Party $party): Acquaintances {
		return parent::remove($party);
	}

	#[Pure] public function isTold(Party $party): bool {
		$id = $party->Id();
		if ($this->has($id)) {
			return $this->isTold[$id->Id()];
		}
		return false;
	}

	public function tell(Party $party): Acquaintances {
		$this->addEntity($party->Id(), true);
		return $this;
	}

	protected function addEntity(Id $id, bool $isTold = false): void {
		parent::addEntity($id);
		$this->isTold[$id->Id()] = $isTold;
	}

	protected function removeEntity(Id $id): void {
		parent::removeEntity($id);
		unset($this->isTold[$id->Id()]);
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array(string=>mixed) $data
	 */
	protected function validateSerializedData(array &$data): void {
		$this->validate($data, 'entities', 'array');
		$this->validate($data, 'isTold', 'array');
	}
}
