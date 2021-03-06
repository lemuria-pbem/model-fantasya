<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\ExpectedValues;
use JetBrains\PhpStorm\Pure;

use Lemuria\Model\World;
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
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
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
	#[Pure] public function __construct() {
		$this->passengers = new Inhabitants($this);
	}

	/**
	 * Get a plain data array of the model's data.
	 */
	#[ArrayShape([
		'id' => 'int', 'name' => 'string', 'description' => 'string', 'passengers' => 'int[]', 'completion' => 'float',
		'ship' => 'string', 'anchor' => 'string'
	])]
	#[Pure]
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
	 */
	public function unserialize(array $data): Serializable {
		parent::unserialize($data);
		$this->setAnchor($data['anchor']);
		$this->setShip(self::createShip($data['ship']));
		$this->setCompletion($data['completion']);
		$this->passengers->unserialize($data['passengers']);
		return $this;
	}

	public function Catalog(): int {
		return Catalog::VESSELS;
	}

	/**
	 * This method will be called by the Catalog after loading is finished; the Collector can initialize its collections
	 * then.
	 */
	public function collectAll(): Collector {
		$this->Passengers()->addCollectorsToAll();
		return $this;
	}

	#[Pure] public function Anchor(): string {
		return $this->anchor;
	}

	#[Pure] public function Completion(): float {
		return $this->completion;
	}

	#[Pure] public function Ship(): Ship {
		return $this->ship;
	}

	#[Pure] public function Space(): int {
		$space = $this->Ship()->Payload();
		foreach ($this->Passengers() as $unit/* @var Unit $unit */) {
			$space -= $unit->Weight();
		}
		return $space;
	}

	#[Pure] public function Passengers(): Inhabitants {
		return $this->passengers;
	}

	public function Region(): Region {
		/* @var Region $region */
		$region = $this->getCollector(__FUNCTION__);
		return $region;
	}

	public function setAnchor(#[ExpectedValues(values: [self::IN_DOCK], valuesFromClass: World::class)] string $anchor): Vessel {
		/** @noinspection PhpExpectedValuesShouldBeUsedInspection */
		if ($anchor === self::IN_DOCK || Lemuria::World()->isDirection($anchor)) {
			$this->anchor = $anchor;
			return $this;
		}
		throw new ModelException('Invalid anchor: ' . $anchor . '.');
	}

	public function setShip(Ship $ship): Vessel {
		$this->ship = $ship;
		return $this;
	}

	public function setCompletion(float $completion): Vessel {
		$completion       = round(abs($completion), 4);
		$this->completion = $completion > 1.0 ? 1.0 : $completion;
		return $this;
	}

	#[Pure] public function getUsedWood(): int {
		return (int)round($this->completion * $this->ship->Wood());
	}

	#[Pure] public function getRemainingWood(): int {
		return $this->ship->Wood() - $this->getUsedWood();
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array (string=>mixed) $data
	 */
	protected function validateSerializedData(array &$data): void {
		parent::validateSerializedData($data);
		$this->validate($data, 'anchor', 'string');
		$this->validate($data, 'ship', 'string');
		$this->validate($data, 'completion', 'float');
		$this->validate($data, 'passengers', 'array');
	}
}
