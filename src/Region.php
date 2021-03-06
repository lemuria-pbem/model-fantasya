<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

use function Lemuria\getClass;
use Lemuria\Collector;
use Lemuria\CollectorTrait;
use Lemuria\Entity;
use Lemuria\Id;
use Lemuria\Lemuria;
use Lemuria\Model\Catalog;
use Lemuria\Model\Exception\NotRegisteredException;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
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
	#[Pure] public function __construct() {
		$this->resources = new Resources();
		$this->estate    = new Estate($this);
		$this->fleet     = new Fleet($this);
		$this->residents = new People($this);
	}

	/**
	 * Get a plain data array of the model's data.
	 */
	#[ArrayShape([
		'id' => 'int', 'name' => 'string', 'description' => 'string', 'luxuries' => 'array|null',
		'residents' => 'int[]', 'fleet' => 'int[]', 'estate' => 'int[]', 'resources' => 'array',
		'landscape' => 'string'
	])]
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
	 */
	#[Pure] public function Catalog(): int {
		return Catalog::LOCATIONS;
	}

	/**
	 * This method will be called by the Catalog after loading is finished; the Collector can initialize its collections
	 * then.
	 */
	public function collectAll(): Collector {
		$this->Residents()->addCollectorsToAll();
		$this->Estate()->addCollectorsToAll();
		$this->Fleet()->addCollectorsToAll();
		return $this;
	}

	#[Pure] public function Landscape(): Landscape {
		return $this->landscape;
	}

	#[Pure] public function Estate(): Estate {
		return $this->estate;
	}

	#[Pure] public function Fleet(): Fleet {
		return $this->fleet;
	}

	#[Pure] public function Resources(): Resources {
		return $this->resources;
	}

	#[Pure] public function Residents(): People {
		return $this->residents;
	}

	#[Pure] public function Luxuries(): ?Luxuries {
		return $this->luxuries;
	}

	public function setLandscape(Landscape $landscape): Region {
		$this->landscape = $landscape;
		return $this;
	}

	public function setLuxuries(?Luxuries $luxuries): Region {
		$this->luxuries = $luxuries;
		return $this;
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array (string=>mixed) $data
	 */
	protected function validateSerializedData(array &$data): void {
		parent::validateSerializedData($data);
		$this->validate($data, 'landscape', 'string');
		$this->validate($data, 'resources', 'array');
		$this->validate($data, 'estate', 'array');
		$this->validate($data, 'fleet', 'array');
		$this->validate($data, 'residents', 'array');
		$this->validate($data, 'luxuries', '?array');
	}
}
