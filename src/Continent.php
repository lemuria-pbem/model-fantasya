<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

use Lemuria\Collector;
use Lemuria\CollectorTrait;
use Lemuria\Entity;
use Lemuria\Exception\UnserializeException;
use Lemuria\Id;
use Lemuria\Identifiable;
use Lemuria\Lemuria;
use Lemuria\Model\Domain;
use Lemuria\Model\Exception\NotRegisteredException;
use Lemuria\Model\Reassignment;
use Lemuria\Serializable;

/**
 * A continent is a landmass of connected regions.
 */
class Continent extends Entity implements Collector, Reassignment
{
	use CollectorTrait;

	private readonly Landmass $landmass;

	/**
	 * @var array(int=>string)
	 */
	private array $names = [];

	/**
	 * @var array(int=>string)
	 */
	private array $descriptions = [];

	/**
	 * Get a Continent.
	 *
	 * @throws NotRegisteredException
	 */
	public static function get(Id $id): self {
		/* @var Continent $continent */
		$continent = Lemuria::Catalog()->get($id, Domain::CONTINENT);
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
	#[ArrayShape([
		'id' => 'int', 'name' => 'string', 'description' => 'string', 'landmass' => 'int[]', 'names' => 'array',
		'descriptions' => 'array'
	])]
	#[Pure] public function serialize(): array {
		$data                 = parent::serialize();
		$data['landmass']     = $this->landmass->serialize();
		$data['names']        = $this->names;
		$data['descriptions'] = $this->descriptions;
		return $data;
	}

	/**
	 * Restore the model's data from serialized data.
	 */
	public function unserialize(array $data): Serializable {
		parent::unserialize($data);
		$this->landmass->unserialize($data['landmass']);
		$this->names        = $data['names'];
		$this->descriptions = $data['descriptions'];
		return $this;
	}

	/**
	 * Get the catalog domain.
	 */
	#[Pure] public function Catalog(): Domain {
		return Domain::CONTINENT;
	}

	/**
	 * This method will be called by the Catalog after loading is finished; the Collector can initialize its collections
	 * then.
	 */
	public function collectAll(): Collector {
		$this->landmass->addCollectorsToAll();
		return $this;
	}

	/**
	 * Get all regions.
	 */
	#[Pure] public function Landmass(): Landmass {
		return $this->landmass;
	}

	public function reassign(Id $oldId, Identifiable $identifiable): void {
		if ($identifiable->Catalog() === Domain::PARTY) {
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
		if ($identifiable->Catalog() === Domain::PARTY) {
			$id = $identifiable->Id()->Id();
			unset($this->names[$id]);
			unset($this->descriptions[$id]);
		}
	}

	#[Pure] public function hasNameFor(Party $party): bool {
		$id = $party->Id()->Id();
		return isset($this->names[$id]);
	}

	#[Pure] public function hasDescriptionFor(Party $party): bool {
		$id = $party->Id()->Id();
		return isset($this->descriptions[$id]);
	}

	#[Pure] public function getNameFor(Party $party): string {
		$id = $party->Id()->Id();
		return $this->names[$id] ?? $this->Name();
	}

	#[Pure] public function getDescriptionFor(Party $party): string {
		$id = $party->Id()->Id();
		return $this->descriptions[$id] ?? $this->Description();
	}

	public function setNameFor(Party $party, ?string $name = null): Continent {
		$id = $party->Id()->Id();
		if ($name) {
			$this->names[$id] = $name;
		} else {
			unset($this->names[$id]);
		}
		return $this;
	}

	public function setDescriptionFor(Party $party, ?string $description = null): Continent {
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
	 * @param array(string=>mixed) $data
	 */
	protected function validateSerializedData(array &$data): void {
		parent::validateSerializedData($data);
		$this->validate($data, 'landmass', 'array');
		$this->validate($data, 'names', 'array');
		foreach ($data['names'] as $id => $name) {
			if (!is_int($id)) {
				throw new UnserializeException('Party name ID is not an int.');
			}
			if (!is_string($name)) {
				throw new UnserializeException('Party name is not a string.');
			}
		}
		$this->validate($data, 'descriptions', 'array');
		foreach ($data['descriptions'] as $id => $description) {
			if (!is_int($id)) {
				throw new UnserializeException('Party description ID is not an int.');
			}
			if (!is_string($description)) {
				throw new UnserializeException('Party description is not a string.');
			}
		}
	}
}
