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

/**
 * A region in the world of Lemuria has a dominant kind of landscape that is the main development factor.
 */
class Region extends Entity implements Collectible, Collector, Location
{
	use BuilderTrait;
	use CollectibleTrait;
	use CollectorTrait;

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
		$data              = parent::serialize();
		$data['landscape'] = getClass($this->Landscape());
		$data['roads']     = $this->roads?->serialize();
		$data['herbage']   = $this->herbage?->serialize();
		$data['resources'] = $this->Resources()->serialize();
		$data['estate']    = $this->Estate()->serialize();
		$data['fleet']     = $this->Fleet()->serialize();
		$data['residents'] = $this->Residents()->serialize();
		$data['luxuries']  = $this->luxuries?->serialize();
		$data['treasury']  = $this->Treasury()->serialize();
		return $data;
	}

	/**
	 * Restore the model's data from serialized data.
	 */
	public function unserialize(array $data): Serializable {
		parent::unserialize($data);
		$this->setLandscape(self::createLandscape($data['landscape']));
		$this->Resources()->unserialize($data['resources']);
		$this->Estate()->unserialize($data['estate']);
		$this->Fleet()->unserialize($data['fleet']);
		$this->Residents()->unserialize($data['residents']);
		if ($data['roads'] === null) {
			$this->roads = null;
		} else {
			$roads = new Roads();
			$roads->unserialize($data['roads']);
			$this->setRoads($roads);
		}
		if ($data['herbage'] === null) {
			$this->herbage = null;
		} else {
			$herbage = new Herbage();
			$herbage->unserialize($data['herbage']);
			$this->setHerbage($herbage);
		}
		if ($data['luxuries'] === null) {
			$this->luxuries = null;
		} else {
			$luxuries = new Luxuries();
			$luxuries->unserialize($data['luxuries']);
			$this->setLuxuries($luxuries);
		}
		$this->Treasury()->unserialize($data['treasury']);
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
	protected function validateSerializedData(array &$data): void {
		parent::validateSerializedData($data);
		$this->validate($data, 'landscape', 'string');
		$this->validate($data, 'roads', '?array');
		$this->validate($data, 'herbage', '?array');
		$this->validate($data, 'resources', 'array');
		$this->validate($data, 'estate', 'array');
		$this->validate($data, 'fleet', 'array');
		$this->validate($data, 'residents', 'array');
		$this->validate($data, 'luxuries', '?array');
		$this->validate($data, 'treasury', 'array');
	}
}
