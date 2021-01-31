<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

use function Lemuria\getClass;
use Lemuria\Collectible;
use Lemuria\CollectibleTrait;
use Lemuria\Collector;
use Lemuria\CollectorTrait;
use Lemuria\Entity;
use Lemuria\Id;
use Lemuria\Lemuria;
use Lemuria\Model\Catalog;
use Lemuria\Model\Exception\NotRegisteredException;
use Lemuria\Model\Lemuria\Factory\BuilderTrait;
use Lemuria\Serializable;

/**
 * A construction is a building in a region that is inhabited by units.
 */
class Construction extends Entity implements Collector, Collectible
{
	use BuilderTrait;
	use CollectibleTrait;
	use CollectorTrait;

	private Building $building;

	private int $size = 0;

	private Inhabitants $inhabitants;

	/**
	 * Get a construction.
	 *
	 * @throws NotRegisteredException
	 */
	public static function get(Id $id): self {
		/* @var Construction $construction */
		$construction = Lemuria::Catalog()->get($id, Catalog::CONSTRUCTIONS);
		return $construction;
	}

	/**
	 * Create an empty construction.
	 */
	#[Pure] public function __construct() {
		$this->inhabitants = new Inhabitants($this);
	}

	/**
	 * Get a plain data array of the model's data.
	 */
	#[ArrayShape([
		'id' => 'int', 'name' => 'string', 'description' => 'string', 'inhabitants' => 'int[]', 'size' => 'int',
		'building' => 'string'
	])]
	#[Pure]
	public function serialize(): array {
		$data                = parent::serialize();
		$data['building']    = getClass($this->Building());
		$data['size']        = $this->Size();
		$data['inhabitants'] = $this->inhabitants->serialize();
		return $data;
	}

	/**
	 * Restore the model's data from serialized data.
	 */
	public function unserialize(array $data): Serializable {
		parent::unserialize($data);
		$this->setBuilding($this->createBuilding($data['building']));
		$this->setSize($data['size']);
		$this->inhabitants->unserialize($data['inhabitants']);
		return $this;
	}

	/**
	 * Get the catalog namespace.
	 */
	public function Catalog(): int {
		return Catalog::CONSTRUCTIONS;
	}

	/**
	 * This method will be called by the Catalog after loading is finished; the Collector can initialize its collections
	 * then.
	 */
	public function collectAll(): Collector {
		$this->Inhabitants()->addCollectorsToAll();
		return $this;
	}

	#[Pure]
	public function Building(): Building {
		return $this->building;
	}

	#[Pure]
	public function Size(): int {
		return $this->size;
	}

	#[Pure]
	public function Inhabitants(): Inhabitants {
		return $this->inhabitants;
	}

	public function setBuilding(Building $building): Construction {
		$this->building = $building;
		$correctedSize  = $building->correctSize($this->size);
		if ($correctedSize !== $this->size) {
			$this->setSize($correctedSize);
		}
		return $this;
	}

	public function setSize(int $size): Construction {
		$this->size = $size;
		$correctedBuilding = $this->building->correctBuilding($size);
		if ($correctedBuilding !== $this->building) {
			$this->setBuilding($correctedBuilding);
		}
		return $this;
	}

	public function Region(): Region {
		/* @var Region $region */
		$region = $this->getCollector(__FUNCTION__);
		return $region;
	}

	#[Pure] public function getFreeSpace(): int {
		return $this->size - count($this->inhabitants);
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array (string=>mixed) $data
	 */
	protected function validateSerializedData(array &$data): void {
		parent::validateSerializedData($data);
		$this->validate($data, 'building', 'string');
		$this->validate($data, 'size', 'int');
		$this->validate($data, 'inhabitants', 'array');
	}
}
