<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use function Lemuria\getClass;
use Lemuria\Collector;
use Lemuria\CollectorTrait;
use Lemuria\Entity;
use Lemuria\Exception\LemuriaException;
use Lemuria\Id;
use Lemuria\Lemuria;
use Lemuria\Model\Catalog;
use Lemuria\Model\Exception\NotRegisteredException;
use Lemuria\Model\Lemuria\Factory\BuilderTrait;
use Lemuria\Model\Location;
use Lemuria\Serializable;

/**
 * A region in the world of Lemuria has a dominant kind of landscape that is the main development factor.
 */
class Region extends Entity implements Collector, Location
{
	use BuilderTrait;
	use CollectorTrait;

	private Landscape $landscape;

	private Resources $resources;

	private Estate $estate;

	private Fleet $fleet;

	private People $residents;

	private ?Luxuries $luxuries = null;

	/**
	 * Get a Region.
	 *
	 * @param Id $id
	 * @return Region
	 * @throws NotRegisteredException
	 */
	public static function get(Id $id): Region {
		/* @var Region $region */
		$region = Lemuria::Catalog()->get($id, Catalog::LOCATIONS);
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
	}

	/**
	 * Get a plain data array of the model's data.
	 *
	 * @return array
	 */
	public function serialize(): array {
		$data              = parent::serialize();
		$data['landscape'] = getClass($this->Landscape());
		$data['resources'] = $this->Resources()->serialize();
		$data['estate']    = $this->Estate()->serialize();
		$data['fleet']     = $this->Fleet()->serialize();
		$data['residents'] = $this->Residents()->serialize();
		$data['luxuries']  = $this->luxuries ? $this->Luxuries()->serialize() : null;
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
		$this->setLandscape(self::createLandscape($data['landscape']));
		$this->Resources()->unserialize($data['resources']);
		$this->Estate()->unserialize($data['estate']);
		$this->Fleet()->unserialize($data['fleet']);
		$this->Residents()->unserialize($data['residents']);
		if ($data['luxuries'] !== null) {
			$luxuries = new Luxuries();
			$luxuries->unserialize($data['luxuries']);
			$this->setLuxuries($luxuries);
		}
		return $this;
	}

	/**
	 * Get the catalog namespace.
	 *
	 * @return int
	 */
	public function Catalog(): int {
		return Catalog::LOCATIONS;
	}

	/**
	 * This method will be called by the Catalog after loading is finished; the Collector can initialize its collections
	 * then.
	 *
	 * @return Collector
	 */
	public function collectAll(): Collector {
		$this->Residents()->addCollectorsToAll();
		$this->Estate()->addCollectorsToAll();
		$this->Fleet()->addCollectorsToAll();
		return $this;
	}

	/**
	 * Get the landscape.
	 *
	 * @return Landscape
	 */
	public function Landscape(): Landscape {
		return $this->landscape;
	}

	/**
	 * Get the estate.
	 *
	 * @return Estate
	 */
	public function Estate(): Estate {
		return $this->estate;
	}

	/**
	 * Get the fleet.
	 *
	 * @return Fleet
	 */
	public function Fleet(): Fleet {
		return $this->fleet;
	}

	/**
	 * Get the resources.
	 *
	 * @return Resources
	 */
	public function Resources(): Resources {
		return $this->resources;
	}

	/**
	 * Get the residents.
	 *
	 * @return People
	 */
	public function Residents(): People {
		return $this->residents;
	}

	/**
	 * Get the luxuries.
	 *
	 * @return Luxuries|null
	 */
	public function Luxuries(): ?Luxuries {
		return $this->luxuries;
	}

	/**
	 * Set the landscape.
	 *
	 * @param Landscape $landscape
	 * @return Region
	 */
	public function setLandscape(Landscape $landscape): Region {
		$this->landscape = $landscape;
		return $this;
	}

	/**
	 * Set the luxuries.
	 *
	 * @param Luxuries $luxuries
	 * @return Region
	 * @throws LemuriaException
	 */
	public function setLuxuries(?Luxuries $luxuries): Region {
		$this->luxuries = $luxuries;
		return $this;
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array (string=>mixed) &$data
	 */
	protected function validateSerializedData(&$data): void {
		parent::validateSerializedData($data);
		$this->validate($data, 'landscape', 'string');
		$this->validate($data, 'resources', 'array');
		$this->validate($data, 'estate', 'array');
		$this->validate($data, 'fleet', 'array');
		$this->validate($data, 'residents', 'array');
		$this->validate($data, 'luxuries', '?array');
	}
}
