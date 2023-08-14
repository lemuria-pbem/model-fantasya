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
use Lemuria\Model\World\Direction;
use Lemuria\Validate;

/**
 * A vessel is a ship that carries passengers.
 */
class Vessel extends Entity implements Collectible, Collector
{
	use BuilderTrait;
	use CollectibleTrait;
	use CollectorTrait;

	private const ANCHOR = 'anchor';

	private const PORT = 'port';

	private const SHIP = 'ship';

	private const COMPLETION = 'completion';

	private const PASSENGERS = 'passengers';

	private const TREASURY = 'treasury';

	private Direction $anchor = Direction::IN_DOCK;

	private Ship $ship;

	private float $completion = 0.0;

	private readonly Inhabitants $passengers;

	private ?Construction $port = null;

	private ?int $portId = null;

	private readonly Treasury $treasury;

	/**
	 * @return array<Vessel>
	 */
	public static function all(): array {
		return Lemuria::Catalog()->getAll(Domain::Vessel);
	}

	/**
	 * Get a vessel.
	 *
	 * @throws NotRegisteredException
	 */
	public static function get(Id $id): self {
		/** @var Vessel $vessel */
		$vessel = Lemuria::Catalog()->get($id, Domain::Vessel);
		return $vessel;
	}

	/**
	 * Create an empty vessel.
	 */
	public function __construct() {
		$this->passengers = new Inhabitants($this);
		$this->treasury   = new Treasury($this);
	}

	public function Catalog(): Domain {
		return Domain::Vessel;
	}

	public function Anchor(): Direction {
		return $this->anchor;
	}

	public function Port(): ?Construction {
		return $this->initPort();
	}

	public function Completion(): float {
		return $this->completion;
	}

	public function Ship(): Ship {
		return $this->ship;
	}

	public function Space(): int {
		$space = $this->Ship()->Payload();
		foreach ($this->Passengers() as $unit /* @var Unit $unit */) {
			$space -= $unit->Weight();
		}
		return $space;
	}

	public function Passengers(): Inhabitants {
		return $this->passengers;
	}

	public function Region(): Region {
		/** @var Region $region */
		$region = $this->getCollector(__FUNCTION__);
		return $region;
	}

	public function Treasury(): Treasury {
		return $this->treasury;
	}

	public function serialize(): array {
		$data                   = parent::serialize();
		$data[self::ANCHOR]     = $this->Anchor();
		$data[self::PORT]       = $this->portId;
		$data[self::SHIP]       = getClass($this->Ship());
		$data[self::COMPLETION] = $this->Completion();
		$data[self::PASSENGERS] = $this->passengers->serialize();
		$data[self::TREASURY]   = $this->Treasury()->serialize();
		return $data;
	}

	/**
	 * Restore the model's data from serialized data.
	 */
	public function unserialize(array $data): static {
		parent::unserialize($data);
		$this->setAnchor(Direction::from($data[self::ANCHOR]));
		$this->initPort($data[self::PORT]);
		$this->setShip(self::createShip($data[self::SHIP]));
		$this->setCompletion($data[self::COMPLETION]);
		$this->passengers->unserialize($data[self::PASSENGERS]);
		$this->Treasury()->unserialize($data[self::TREASURY]);
		return $this;
	}

	/**
	 * This method will be called by the Catalog after loading is finished; the Collector can initialize its collections
	 * then.
	 */
	public function collectAll(): static {
		$this->Passengers()->addCollectorsToAll();
		$this->Treasury()->addCollectorsToAll();
		return $this;
	}

	public function setAnchor(Direction $anchor): static {
		$this->anchor = $anchor;
		return $this;
	}

	public function setPort(?Construction $port): static {
		$this->port   = $port;
		$this->portId = $port?->Id()->Id();
		return $this;
	}

	public function setShip(Ship $ship): static {
		$this->ship = $ship;
		return $this;
	}

	public function setCompletion(float $completion): static {
		$completion       = round(abs($completion), 4);
		$this->completion = min($completion, 1.0);
		return $this;
	}

	public function getUsedWood(): int {
		return (int)round($this->completion * $this->ship->Wood());
	}

	public function getRemainingWood(): int {
		return $this->ship->Wood() - $this->getUsedWood();
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		parent::validateSerializedData($data);
		$this->validate($data, self::ANCHOR, Validate::String);
		$this->validate($data, self::PORT, Validate::IntOrNull);
		$this->validate($data, self::SHIP, Validate::String);
		$this->validate($data, self::COMPLETION, Validate::Float);
		$this->validate($data, self::PASSENGERS, Validate::Array);
		$this->validate($data, self::TREASURY, Validate::Array);
	}

	private function initPort(?int $portId = null): ?Construction {
		if ($portId) {
			$this->portId = $portId;
		}
		if (!$this->port && $this->portId) {
			$this->port = Construction::get(new Id($this->portId));
		}
		return $this->port;
	}
}
