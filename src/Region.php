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
use Lemuria\Model\Location;
use Lemuria\Model\World\Direction;
use Lemuria\Serializable;
use Lemuria\Validate;

/**
 * A region in the world of Lemuria has a dominant kind of landscape that is the main development factor.
 */
class Region extends Entity implements Collectible, Collector, Location
{
	use BuilderTrait;
	use CollectibleTrait;
	use CollectorTrait;

	private const LANDSCAPE = 'landscape';

	private const ROADS = 'roads';

	private const HERBAGE = 'herbage';

	private const RESOURCES = 'resources';

	private const ESTATE = 'estate';

	private const FLEET = 'fleet';

	private const RESIDENTS = 'residents';

	private const LUXURIES = 'luxuries';

	private const TREASURY = 'treasury';

	private Landscape $landscape;

	private ?Roads $roads = null;

	private readonly Resources $resources;

	private readonly Estate $estate;

	private readonly Fleet $fleet;

	private readonly People $residents;

	private ?Herbage $herbage = null;

	private float $occurrence = 0.0;

	private ?Luxuries $luxuries = null;

	private readonly Treasury $treasury;

	/**
	 * Get a Region.
	 *
	 * @throws NotRegisteredException
	 */
	public static function get(Id $id): Region {
		/** @var Region $region */
		$region = Lemuria::Catalog()->get($id, Domain::LOCATION);
		return $region;
	}

	/**
	 * Create an empty region.
	 */
	public function __construct() {
		$this->resources = new Resources();
		$this->estate    = new Estate($this);
		$this->fleet     = new Fleet($this);
		$this->residents = new People($this);
		$this->treasury  = new Treasury($this);
	}

	/**
	 * Get the catalog namespace.
	 */
	public function Catalog(): Domain {
		return Domain::LOCATION;
	}

	public function Landscape(): Landscape {
		return $this->landscape;
	}

	public function Roads(): ?Roads {
		return $this->roads;
	}

	public function Herbage(): ?Herbage {
		return $this->herbage;
	}

	public function Estate(): Estate {
		return $this->estate;
	}

	public function Fleet(): Fleet {
		return $this->fleet;
	}

	public function Resources(): Resources {
		return $this->resources;
	}

	public function Residents(): People {
		return $this->residents;
	}

	public function Luxuries(): ?Luxuries {
		return $this->luxuries;
	}

	public function Treasury(): Treasury {
		return $this->treasury;
	}

	public function Continent(): ?Continent {
		if ($this->hasCollector(__FUNCTION__)) {
			/** @var Continent $continent */
			$continent = $this->getCollector(__FUNCTION__);
			return $continent;
		}
		return null;
	}

	/**
	 * Get a plain data array of the model's data.
	 */
	public function serialize(): array {
		$data                  = parent::serialize();
		$data[self::LANDSCAPE] = getClass($this->Landscape());
		$data[self::ROADS]     = $this->roads?->serialize();
		$data[self::HERBAGE]   = $this->herbage?->serialize();
		$data[self::RESOURCES] = $this->Resources()->serialize();
		$data[self::ESTATE]    = $this->Estate()->serialize();
		$data[self::FLEET]     = $this->Fleet()->serialize();
		$data[self::RESIDENTS] = $this->Residents()->serialize();
		$data[self::LUXURIES]  = $this->luxuries?->serialize();
		$data[self::TREASURY]  = $this->Treasury()->serialize();
		return $data;
	}

	/**
	 * Restore the model's data from serialized data.
	 */
	public function unserialize(array $data): Serializable {
		parent::unserialize($data);
		$this->setLandscape(self::createLandscape($data[self::LANDSCAPE]));
		$this->Resources()->unserialize($data[self::RESOURCES]);
		$this->Estate()->unserialize($data[self::ESTATE]);
		$this->Fleet()->unserialize($data[self::FLEET]);
		$this->Residents()->unserialize($data[self::RESIDENTS]);
		if ($data[self::ROADS] === null) {
			$this->roads = null;
		} else {
			$roads = new Roads();
			$roads->unserialize($data[self::ROADS]);
			$this->setRoads($roads);
		}
		if ($data[self::HERBAGE] === null) {
			$this->herbage = null;
		} else {
			$herbage = new Herbage();
			$herbage->unserialize($data[self::HERBAGE]);
			$this->setHerbage($herbage);
		}
		if ($data[self::LUXURIES] === null) {
			$this->luxuries = null;
		} else {
			$luxuries = new Luxuries();
			$luxuries->unserialize($data[self::LUXURIES]);
			$this->setLuxuries($luxuries);
		}
		$this->Treasury()->unserialize($data[self::TREASURY]);
		return $this;
	}

	/**
	 * This method will be called by the Catalog after loading is finished; the Collector can initialize its collections
	 * then.
	 */
	public function collectAll(): Collector {
		$this->Residents()->addCollectorsToAll();
		$this->Estate()->addCollectorsToAll();
		$this->Fleet()->addCollectorsToAll();
		$this->Treasury()->addCollectorsToAll();
		return $this;
	}

	public function hasRoad(Direction $direction): bool {
		return isset($this->roads[$direction->value]) && $this->roads[$direction->value] >= 1.0;
	}

	public function setLandscape(Landscape $landscape): Region {
		$this->landscape = $landscape;
		return $this;
	}

	public function setRoads(?Roads $roads): Region {
		$this->roads = $roads;
		return $this;
	}

	public function setHerbage(?Herbage $herbage): Region {
		$this->herbage = $herbage;
		return $this;
	}

	public function setLuxuries(?Luxuries $luxuries): Region {
		$this->luxuries = $luxuries;
		return $this;
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		parent::validateSerializedData($data);
		$this->validate($data, self::LANDSCAPE, Validate::String);
		$this->validate($data, self::ROADS, Validate::ArrayOrNull);
		$this->validate($data, self::HERBAGE, Validate::ArrayOrNull);
		$this->validate($data, self::RESOURCES, Validate::Array);
		$this->validate($data, self::ESTATE, Validate::Array);
		$this->validate($data, self::FLEET, Validate::Array);
		$this->validate($data, self::RESIDENTS, Validate::Array);
		$this->validate($data, self::LUXURIES, Validate::ArrayOrNull);
		$this->validate($data, self::TREASURY, Validate::Array);
	}
}
