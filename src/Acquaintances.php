<?php
/** @noinspection PhpRedundantMethodOverrideInspection */
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\EntitySet;
use Lemuria\Exception\UnserializeException;
use Lemuria\Id;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;
use Lemuria\Validate;

/**
 * The people of a player or party is the community of all its units.
 */
class Acquaintances extends Gathering
{
	use SerializableTrait;

	private const ENTITIES = 'entities';

	private const IS_TOLD = 'isTold';

	/**
	 * @var array(int=>bool)
	 */
	private array $isTold = [];

	/**
	 * Get a plain data array of the model's data.
	 *
	 * @return int[]
	 */
	public function serialize(): array {
		$entities = [];
		$isTold   = [];
		foreach ($this->isTold as $id => $told) {
			$entities[] = $id;
			$isTold[]   = $told;
		}
		return [self::ENTITIES => $entities, self::IS_TOLD => $isTold];
	}

	/**
	 * Restore the model's data from serialized data.
	 *
	 * @param array<string, array> $data
	 */
	public function unserialize(array $data): Serializable {
		$this->validateSerializedData($data);
		if ($this->count() > 0) {
			$this->clear();
		}

		$entities = array_values($data[self::ENTITIES]);
		$isTold   = array_values($data[self::IS_TOLD]);
		$n        = count($entities);
		if (count($isTold) !== $n) {
			throw new UnserializeException('Mismatch of ' . self::ENTITIES . ' and ' . self::IS_TOLD . ' count.');
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

	public function isTold(Party $party): bool {
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
		$id                = $id->Id();
		$isTold            = $isTold || ($this->isTold[$id] ?? false);
		$this->isTold[$id] = $isTold;
	}

	protected function removeEntity(Id $id): void {
		parent::removeEntity($id);
		unset($this->isTold[$id->Id()]);
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		$this->validate($data, self::ENTITIES, Validate::Array);
		$this->validate($data, self::IS_TOLD, Validate::Array);
	}
}
