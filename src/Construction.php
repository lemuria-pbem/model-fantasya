<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use function Lemuria\getClass;
use Lemuria\Collectible;
use Lemuria\CollectibleTrait;
use Lemuria\Collector;
use Lemuria\CollectorTrait;
use Lemuria\Entity;
use Lemuria\Id;
use Lemuria\Lemuria;
use Lemuria\Model\Domain;
use Lemuria\Model\Exception\NotRegisteredException;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Serializable;

/**
 * A construction is a building in a region that is inhabited by units.
 */
class Construction extends Entity implements Collectible, Collector
{
	use BuilderTrait;
	use CollectibleTrait;
	use CollectorTrait;

	private Building $building;

	private int $size = 0;

	private readonly Inhabitants $inhabitants;

	private readonly Treasury $treasury;

	/**
	 * Get a construction.
	 *
	 * @throws NotRegisteredException
	 */
	public static function get(Id $id): self {
		/** @var Construction $construction */
		$construction = Lemuria::Catalog()->get($id, Domain::CONSTRUCTION);
		return $construction;
	}

	/**
	 * Create an empty construction.
	 */
	public function __construct() {
		$this->inhabitants = new Inhabitants($this);
		$this->treasury    = new Treasury($this);
	}

	/**
	 * Get the catalog domain.
	 */
	public function Catalog(): Domain {
		return Domain::CONSTRUCTION;
	}


	public function Building(): Building {
		return $this->building;
	}


	public function Size(): int {
		return $this->size;
	}


	public function Inhabitants(): Inhabitants {
		return $this->inhabitants;
	}

	public function Region(): Region {
		/** @var Region $region */
		$region = $this->getCollector(__FUNCTION__);
		return $region;
	}

	public function Treasury(): Treasury {
		return $this->treasury;
	}

	/**
	 * Get a plain data array of the model's data.
	 */
	public function serialize(): array {
		$data                = parent::serialize();
		$data['building']    = getClass($this->Building());
		$data['size']        = $this->Size();
		$data['inhabitants'] = $this->inhabitants->serialize();
		$data['treasury']    = $this->Treasury()->serialize();
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
		$this->Treasury()->unserialize($data['treasury']);
		return $this;
	}

	/**
	 * This method will be called by the Catalog after loading is finished; the Collector can initialize its collections
	 * then.
	 */
	public function collectAll(): Collector {
		$this->Inhabitants()->addCollectorsToAll();
		$this->Treasury()->addCollectorsToAll();
		return $this;
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
		$this->size        = $size;
		$correctedBuilding = $this->building->correctBuilding($size);
		if ($correctedBuilding !== $this->building) {
			$this->setBuilding($correctedBuilding);
		}
		return $this;
	}

	public function getFreeSpace(): int {
		return max(0, $this->size - $this->inhabitants->Size());
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
		$this->validate($data, 'treasury', 'array');
	}
}
