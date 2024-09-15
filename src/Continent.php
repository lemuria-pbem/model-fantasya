<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Collector;
use Lemuria\Entity;
use Lemuria\Exception\UnserializeException;
use Lemuria\Id;
use Lemuria\Identifiable;
use Lemuria\Lemuria;
use Lemuria\Model\Domain;
use Lemuria\Model\Exception\NotRegisteredException;
use Lemuria\Model\Reassignment;
use Lemuria\Validate;

/**
 * A continent is a landmass of connected regions.
 */
class Continent extends Entity implements Collector, Reassignment
{
	use CollectorTrait;

	private const string LANDMASS = 'landmass';

	private const string NAMES = 'names';

	private const string DESCRIPTIONS = 'descriptions';

	private readonly Landmass $landmass;

	/**
	 * @var array<int, string>
	 */
	private array $names = [];

	/**
	 * @var array<int, string>
	 */
	private array $descriptions = [];

	/**
	 * @return array<Continent>
	 */
	public static function all(): array {
		return Lemuria::Catalog()->getAll(Domain::Continent);
	}

	/**
	 * Get a Continent.
	 *
	 * @throws NotRegisteredException
	 */
	public static function get(Id $id): self {
		/** @var Continent $continent */
		$continent = Lemuria::Catalog()->get($id, Domain::Continent);
		return $continent;
	}

	/**
	 * Create an empty continent.
	 */
	public function __construct() {
		$this->landmass = new Landmass($this);
		Lemuria::Catalog()->addReassignment($this);
	}

	/**
	 * Get a plain data array of the model's data.
	 *
	 * @return array
	 */
	public function serialize(): array {
		$data                 = parent::serialize();
		$data[self::LANDMASS]     = $this->landmass->serialize();
		$data[self::NAMES]        = $this->names;
		$data[self::DESCRIPTIONS] = $this->descriptions;
		return $data;
	}

	/**
	 * Restore the model's data from serialized data.
	 */
	public function unserialize(array $data): static {
		parent::unserialize($data);
		$this->landmass->unserialize($data[self::LANDMASS]);
		$this->names        = $data[self::NAMES];
		$this->descriptions = $data[self::DESCRIPTIONS];
		return $this;
	}

	/**
	 * Get the catalog domain.
	 */
	public function Catalog(): Domain {
		return Domain::Continent;
	}

	/**
	 * Get all regions.
	 */
	public function Landmass(): Landmass {
		return $this->landmass;
	}

	public function reassign(Id $oldId, Identifiable $identifiable): void {
		if ($identifiable->Catalog() === Domain::Party) {
			$oldId = $oldId->Id();
			$newId = $identifiable->Id()->Id();
			if (isset($this->names[$oldId])) {
				$this->names[$newId] = $this->names[$oldId];
				unset($this->names[$oldId]);
			}
			if (isset($this->descriptions[$oldId])) {
				$this->descriptions[$newId] = $this->descriptions[$oldId];
				unset($this->descriptions[$oldId]);
			}
		}
	}

	public function remove(Identifiable $identifiable): void {
		if ($identifiable->Catalog() === Domain::Party) {
			$id = $identifiable->Id()->Id();
			unset($this->names[$id]);
			unset($this->descriptions[$id]);
		}
	}

	public function hasNameFor(Party $party): bool {
		$id = $party->Id()->Id();
		return isset($this->names[$id]);
	}

	public function hasDescriptionFor(Party $party): bool {
		$id = $party->Id()->Id();
		return isset($this->descriptions[$id]);
	}

	public function getNameFor(Party $party): string {
		$id = $party->Id()->Id();
		return $this->names[$id] ?? $this->Name();
	}

	public function getDescriptionFor(Party $party): string {
		$id = $party->Id()->Id();
		return $this->descriptions[$id] ?? $this->Description();
	}

	public function setNameFor(Party $party, ?string $name = null): static {
		$id = $party->Id()->Id();
		if ($name) {
			$this->names[$id] = $name;
		} else {
			unset($this->names[$id]);
		}
		return $this;
	}

	public function setDescriptionFor(Party $party, ?string $description = null): static {
		$id = $party->Id()->Id();
		if ($description) {
			$this->descriptions[$id] = $description;
		} else {
			unset($this->descriptions[$id]);
		}
		return $this;
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		parent::validateSerializedData($data);
		$this->validate($data, self::LANDMASS, Validate::Array);
		$this->validate($data, self::NAMES, Validate::Array);
		foreach ($data[self::NAMES] as $id => $name) {
			if (!is_int($id)) {
				throw new UnserializeException('Party name ID is not an int.');
			}
			if (!is_string($name)) {
				throw new UnserializeException('Party name is not a string.');
			}
		}
		$this->validate($data, self::DESCRIPTIONS, Validate::Array);
		foreach ($data[self::DESCRIPTIONS] as $id => $description) {
			if (!is_int($id)) {
				throw new UnserializeException('Party description ID is not an int.');
			}
			if (!is_string($description)) {
				throw new UnserializeException('Party description is not a string.');
			}
		}
	}
}
