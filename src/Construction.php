<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use function Lemuria\getClass;
use Lemuria\Collectible;
use Lemuria\CollectibleTrait;
use Lemuria\Collector;
use Lemuria\CollectorTrait;
use Lemuria\Entity;
use Lemuria\Exception\LemuriaException;
use Lemuria\Id;
use Lemuria\Lemuria;
use Lemuria\Model\Catalog;
use Lemuria\Model\Exception\NotRegisteredException;
use Lemuria\Model\Lemuria\Building\Castle;
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
	 * @param Id $id
	 * @return Construction
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
	public function __construct() {
		$this->inhabitants = new Inhabitants($this);
	}

	/**
	 * Get a plain data array of the model's data.
	 *
	 * @return array
	 */
	public function serialize(): array {
		$data                = parent::serialize();
		$data['building']    = getClass($this->Building());
		$data['size']        = $this->Size();
		$data['inhabitants'] = $this->inhabitants->serialize();
		return $data;
	}

	/**
	 * Restore the model's data from serialized data.
	 *
	 * @param array $data
	 * @return Serializable
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
	 *
	 * @return int
	 */
	public function Catalog(): int {
		return Catalog::CONSTRUCTIONS;
	}

	/**
	 * This method will be called by the Catalog after loading is finished; the Collector can initialize its collections
	 * then.
	 *
	 * @return Collector
	 */
	public function collectAll(): Collector {
		$this->Inhabitants()->addCollectorsToAll();
		return $this;
	}

	/**
	 * Get the building.
	 *
	 * @return Building
	 */
	public function Building(): Building {
		return $this->building;
	}

	/**
	 * Get the size.
	 *
	 * @return int
	 */
	public function Size(): int {
		return $this->size;
	}

	/**
	 * Get the inhabitants.
	 *
	 * @return Inhabitants
	 */
	public function Inhabitants(): Inhabitants {
		return $this->inhabitants;
	}

	/**
	 * Set the building.
	 *
	 * @param Building $building
	 * @return Construction
	 */
	public function setBuilding(Building $building): Construction {
		$this->building = $building;
		if ($building instanceof Castle) {
			if ($this->Size() < $building->MinSize()) {
				$this->setSize($building->MinSize());
			} elseif ($this->Size() > $building->MaxSize()) {
				$this->setSize($building->MaxSize());
			}
		}
		return $this;
	}

	/**
	 * Set the size.
	 *
	 * @param int $size
	 * @return Construction
	 */
	public function setSize(int $size): Construction {
		$building = $this->Building();
		if ($building instanceof Castle) {
			if ($size < $building->MinSize() || $size > $building->MaxSize()) {
				throw new LemuriaException('Invalid size for this castle.');
			}
		}
		$this->size = $size;
		return $this;
	}

	/**
	 * Get the Region where this construction is built.
	 *
	 * @return Region
	 */
	public function Region(): Region {
		/* @var Region $region */
		$region = $this->getCollector(__FUNCTION__);
		return $region;
	}

	/**
	 * Get the free space for additional inhabitants.
	 *
	 * @return int
	 */
	public function getFreeSpace(): int {
		return $this->size - count($this->inhabitants);
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array (string=>mixed) &$data
	 */
	protected function validateSerializedData(&$data): void {
		parent::validateSerializedData($data);
		$this->validate($data, 'building', 'string');
		$this->validate($data, 'size', 'int');
		$this->validate($data, 'inhabitants', 'array');
	}
}
