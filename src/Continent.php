<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

use Lemuria\Collector;
use Lemuria\CollectorTrait;
use Lemuria\Entity;
use Lemuria\Id;
use Lemuria\Lemuria;
use Lemuria\Model\Catalog;
use Lemuria\Model\Exception\NotRegisteredException;
use Lemuria\Serializable;

/**
 * A continent is a landmass of connected regions.
 */
class Continent extends Entity implements Collector
{
	use CollectorTrait;

	private Landmass $landmass;

	/**
	 * Get a Continent.
	 *
	 * @throws NotRegisteredException
	 */
	public static function get(Id $id): self {
		/* @var Continent $continent */
		$continent = Lemuria::Catalog()->get($id, Catalog::CONTINENTS);
		return $continent;
	}

	/**
	 * Create an empty continent.
	 */
	#[Pure] public function __construct() {
		$this->landmass = new Landmass();
	}

	/**
	 * Get a plain data array of the model's data.
	 *
	 * @return array
	 */
	#[ArrayShape([
		'id' => 'int', 'name' => 'string', 'description' => 'string', 'landmass' => 'int[]'
	])]
	#[Pure] public function serialize(): array {
		$data             = parent::serialize();
		$data['landmass'] = $this->landmass->serialize();
		return $data;
	}

	/**
	 * Restore the model's data from serialized data.
	 */
	public function unserialize(array $data): Serializable {
		parent::unserialize($data);
		$this->landmass->unserialize($data['landmass']);
		return $this;
	}

	/**
	 * Get the catalog namespace.
	 */
	#[Pure] public function Catalog(): int {
		return Catalog::CONTINENTS;
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

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array(string=>mixed) $data
	 */
	protected function validateSerializedData(array &$data): void {
		parent::validateSerializedData($data);
		$this->validate($data, 'landmass', 'array');
	}
}
