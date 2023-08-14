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
use Lemuria\Model\Sized;
use Lemuria\Validate;

/**
 * A construction is a building in a region that is inhabited by units.
 */
class Construction extends Entity implements Collectible, Collector, Sized
{
	use BuilderTrait;
	use CollectibleTrait;
	use CollectorTrait;
	use ExtensionTrait;

	private const BUILDING = 'building';

	private const SIZE = 'size';

	private const INHABITANTS = 'inhabitants';

	private const TREASURY = 'treasury';

	private Building $building;

	private int $size = 0;

	private readonly Inhabitants $inhabitants;

	private readonly Treasury $treasury;

	/**
	 * @return array<Construction>
	 */
	public static function all(): array {
		return Lemuria::Catalog()->getAll(Domain::Construction);
	}

	/**
	 * Get a construction.
	 *
	 * @throws NotRegisteredException
	 */
	public static function get(Id $id): self {
		/** @var Construction $construction */
		$construction = Lemuria::Catalog()->get($id, Domain::Construction);
		return $construction;
	}

	/**
	 * Create an empty construction.
	 */
	public function __construct() {
		$this->inhabitants = new Inhabitants($this);
		$this->treasury    = new Treasury($this);
		$this->initExtensions();
	}

	/**
	 * Get the catalog domain.
	 */
	public function Catalog(): Domain {
		return Domain::Construction;
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

	public function StructurePoints(): int {
		return $this->size * $this->building->StructurePoints();
	}

	/**
	 * Get a plain data array of the model's data.
	 */
	public function serialize(): array {
		$data                = parent::serialize();
		$data[self::BUILDING]    = getClass($this->Building());
		$data[self::SIZE]        = $this->Size();
		$data[self::INHABITANTS] = $this->inhabitants->serialize();
		$data[self::TREASURY]    = $this->Treasury()->serialize();
		$this->serializeExtensions($data);
		return $data;
	}

	/**
	 * Restore the model's data from serialized data.
	 */
	public function unserialize(array $data): static {
		parent::unserialize($data);
		$this->setBuilding($this->createBuilding($data[self::BUILDING]));
		$this->setSize($data[self::SIZE]);
		$this->inhabitants->unserialize($data[self::INHABITANTS]);
		$this->Treasury()->unserialize($data[self::TREASURY]);
		$this->unserializeExtensions($data);
		return $this;
	}

	/**
	 * This method will be called by the Catalog after loading is finished; the Collector can initialize its collections
	 * then.
	 */
	public function collectAll(): static {
		$this->Inhabitants()->addCollectorsToAll();
		$this->Treasury()->addCollectorsToAll();
		return $this;
	}

	public function setBuilding(Building $building): static {
		$this->building = $building;
		$correctedSize  = $building->correctSize($this->size);
		if ($correctedSize !== $this->size) {
			$this->setSize($correctedSize);
		}
		return $this;
	}

	public function setSize(int $size): static {
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
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		parent::validateSerializedData($data);
		$this->validate($data, self::BUILDING, Validate::String);
		$this->validate($data, self::SIZE, Validate::Int);
		$this->validate($data, self::INHABITANTS, Validate::Array);
		$this->validate($data, self::TREASURY, Validate::Array);
		$this->validateExtensions($data);
	}
}
