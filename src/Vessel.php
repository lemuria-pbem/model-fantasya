<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

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
use Lemuria\Model\Exception\ModelException;
use Lemuria\Model\Lemuria\Factory\BuilderTrait;
use Lemuria\Serializable;

/**
 * A vessel is a ship that carries passengers.
 */
class Vessel extends Entity implements Collector, Collectible
{
	use BuilderTrait;
	use CollectibleTrait;
	use CollectorTrait;

	const IN_DOCK = '';

	private string $anchor = self::IN_DOCK;

	private Ship $ship;

	private float $completion = 0.0;

	private Inhabitants $passengers;

	/**
	 * Get a vessel.
	 *
	 * @param Id $id
	 * @return Vessel
	 * @throws NotRegisteredException
	 */
	public static function get(Id $id): Vessel {
		/* @var Vessel $vessel */
		$vessel = Lemuria::Catalog()->get($id, Catalog::VESSELS);
		return $vessel;
	}

	/**
	 * Create an empty vessel.
	 */
	public function __construct() {
		$this->passengers = new Inhabitants($this);
	}

	/**
	 * Get a plain data array of the model's data.
	 *
	 * @return array
	 */
	public function serialize(): array {
		$data               = parent::serialize();
		$data['anchor']     = $this->Anchor();
		$data['ship']       = getClass($this->Ship());
		$data['completion'] = $this->Completion();
		$data['passengers'] = $this->passengers->serialize();
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
		$this->setAnchor($data['anchor']);
		$this->setShip(self::createShip($data['ship']));
		$this->setCompletion($data['completion']);
		$this->passengers->unserialize($data['passengers']);
		return $this;
	}

	/**
	 * Get the catalog namespace.
	 *
	 * @return int
	 */
	public function Catalog(): int {
		return Catalog::VESSELS;
	}

	/**
	 * This method will be called by the Catalog after loading is finished; the Collector can initialize its collections
	 * then.
	 *
	 * @return Collector
	 */
	public function collectAll(): Collector {
		$this->Passengers()->addCollectorsToAll();
		return $this;
	}

	/**
	 * Get the anchor.
	 *
	 * @return string
	 */
	public function Anchor(): string {
		return $this->anchor;
	}

	/**
	 * Get the completion.
	 *
	 * @return float
	 */
	public function Completion(): float {
		return $this->completion;
	}

	/**
	 * Get the ship.
	 *
	 * @return Ship
	 */
	public function Ship(): Ship {
		return $this->ship;
	}

	/**
	 * Get the free space on this Vessel.
	 *
	 * @return int
	 */
	public function Space(): int {
		$space = $this->Ship()->Payload();
		foreach ($this->Passengers() as $unit/* @var Unit $unit */) {
			$space -= $unit->Weight();
		}
		return $space;
	}

	/**
	 * Get the passengers.
	 *
	 * @return Inhabitants
	 */
	public function Passengers(): Inhabitants {
		return $this->passengers;
	}

	/**
	 * Get the Region where this vessel is in.
	 *
	 * @return Region
	 */
	public function Region(): Region {
		/* @var Region $region */
		$region = $this->getCollector(__FUNCTION__);
		return $region;
	}

	/**
	 * Set the anchor.
	 *
	 * @param string $anchor
	 * @return Vessel
	 */
	public function setAnchor(string $anchor): Vessel {
		if ($anchor === self::IN_DOCK || Lemuria::World()->isDirection($anchor)) {
			$this->anchor = $anchor;
			return $this;
		}
		throw new ModelException('Invalid anchor: ' . $anchor . '.');
	}

	/**
	 * Set the ship.
	 *
	 * @param Ship $ship
	 * @return Vessel
	 */
	public function setShip(Ship $ship): Vessel {
		$this->ship = $ship;
		return $this;
	}

	/**
	 * Set the completion.
	 *
	 * @param float $completion
	 * @return Vessel
	 */
	public function setCompletion(float $completion): Vessel {
		$this->completion = $completion;
		return $this;
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array (string=>mixed) &$data
	 */
	protected function validateSerializedData(&$data): void {
		parent::validateSerializedData($data);
		$this->validate($data, 'anchor', 'string');
		$this->validate($data, 'ship', 'string');
		$this->validate($data, 'completion', 'float');
		$this->validate($data, 'passengers', 'array');
	}
}
