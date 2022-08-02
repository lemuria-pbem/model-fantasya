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
use Lemuria\Model\Fantasya\Combat\BattleRow;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Serializable;

/**
 * A unit consists of a number of persons of the same race.
 */
class Unit extends Entity implements Collectible, Collector
{
	use BuilderTrait;
	use CollectibleTrait;
	use CollectorTrait;

	private Race $race;

	private int $size = 0;

	private float $health = 1.0;

	private bool $isGuarding = false;

	private BattleRow $battleRow = BattleRow::BYSTANDER;

	private bool $isHiding = false;

	private bool $isLooting = true;

	private Id|false|null $disguiseAs = false;

	private readonly Resources $inventory;

	private readonly Treasury $treasury;

	private readonly Knowledge $knowledge;

	private ?Aura $aura = null;

	private ?BattleSpells $battleSpells = null;

	/**
	 * Get a Unit.
	 *
	 * @throws NotRegisteredException
	 */
	public static function get(Id $id): Unit {
		/** @var Unit $unit */
		$unit = Lemuria::Catalog()->get($id, Domain::UNIT);
		return $unit;
	}

	/**
	 * Create a new unit.
	 */
	public function __construct() {
		$this->inventory = new Resources();
		$this->treasury  = new Treasury($this);
		$this->knowledge = new Knowledge();
	}

	public function Catalog(): Domain {
		return Domain::UNIT;
	}

	public function Aura(): ?Aura {
		return $this->aura;
	}

	public function BattleSpells(): ?BattleSpells {
		return $this->battleSpells;
	}

	public function Inventory(): Resources {
		return $this->inventory;
	}

	public function Treasury(): Treasury {
		return $this->treasury;
	}

	public function Knowledge(): Knowledge {
		return $this->knowledge;
	}

	public function Race(): Race {
		return $this->race;
	}

	public function Size(): int {
		return $this->size;
	}

	public function Health(): float {
		return $this->health;
	}

	public function IsGuarding(): bool {
		return $this->isGuarding;
	}

	public function BattleRow(): BattleRow {
		return $this->battleRow;
	}

	public function IsHiding(): bool {
		return $this->isHiding;
	}

	public function IsLooting(): bool {
		return $this->isLooting;
	}

	public function Disguise(): Party|false|null {
		if ($this->disguiseAs instanceof Id) {
			return Party::get($this->disguiseAs);
		}
		return $this->disguiseAs;
	}

	public function Party(): Party {
		/** @var Party $party */
		$party = $this->getCollector(__FUNCTION__);
		return $party;
	}

	public function Region(): Region {
		/** @var Region $region */
		$region = $this->getCollector(__FUNCTION__);
		return $region;
	}

	public function Construction(): ?Construction {
		if ($this->hasCollector(__FUNCTION__)) {
			/** @var Construction $construction */
			$construction = $this->getCollector(__FUNCTION__);
			return $construction;
		}
		return null;
	}

	public function Vessel(): ?Vessel {
		if ($this->hasCollector(__FUNCTION__)) {
			/** @var Vessel $vessel */
			$vessel = $this->getCollector(__FUNCTION__);
			return $vessel;
		}
		return null;
	}

	/**
	 * Get the total weight of this Unit including its inventory.
	 */
	public function Weight(): int {
		$weight = $this->Size() * $this->Race()->Weight();
		foreach ($this->Inventory() as $quantity /* @var Quantity $quantity */) {
			$weight += $quantity->Weight();
		}
		foreach ($this->Treasury() as $unicum /* @var Unicum $unicum */) {
			$weight += $unicum->Composition()->Weight();
		}
		return $weight;
	}

	/**
	 * This method will be called by the Catalog after loading is finished; the Collector can initialize its collections
	 * then.
	 */
	public function collectAll(): Collector {
		$this->Treasury()->addCollectorsToAll();
		return $this;
	}

	public function serialize(): array {
		$data                 = parent::serialize();
		$data['race']         = getClass($this->Race());
		$data['size']         = $this->Size();
		$data['aura']         = $this->aura?->serialize();
		$data['health']       = $this->Health();
		$data['isGuarding']   = $this->IsGuarding();
		$data['battleRow']    = $this->BattleRow();
		$data['isHiding']     = $this->IsHiding();
		$data['isLooting']    = $this->IsLooting();
		$id                   = $this->disguiseAs;
		$data['disguiseAs']   = $id instanceof Id ? $id->Id() : $id;
		$data['inventory']    = $this->Inventory()->serialize();
		$data['treasury']     = $this->Treasury()->serialize();
		$data['knowledge']    = $this->Knowledge()->serialize();
		$data['battleSpells'] = $this->battleSpells?->serialize();
		return $data;
	}

	/**
	 * Restore the model's data from serialized data.
	 */
	public function unserialize(array $data): Serializable {
		parent::unserialize($data);
		$this->setRace(self::createRace($data['race']));
		$this->setSize($data['size']);
		$this->setHealth($data['health']);
		$this->setIsGuarding($data['isGuarding']);
		$this->setBattleRow(BattleRow::from($data['battleRow']));
		$this->setIsHiding($data['isHiding']);
		$this->setIsLooting($data['isLooting']);
		$id               = $data['disguiseAs'];
		$this->disguiseAs = is_int($id) ? new Id($id) : $id;
		$this->Inventory()->unserialize($data['inventory']);
		$this->Treasury()->unserialize($data['treasury']);
		$this->Knowledge()->unserialize($data['knowledge']);
		if (isset($data['aura'])) {
			$this->aura = new Aura();
			$this->aura->unserialize($data['aura']);
		}
		if (isset($data['battleSpells'])) {
			$this->battleSpells = new BattleSpells();
			$this->battleSpells->unserialize($data['battleSpells']);
		}
		return $this;
	}

	public function setAura(?Aura $aura): Unit {
		$this->aura = $aura;
		return $this;
	}

	public function setBattleSpells(?BattleSpells $battleSpells): Unit {
		$this->battleSpells = $battleSpells;
		return $this;
	}

	public function setRace(Race $race): Unit {
		$this->race = $race;
		return $this;
	}

	public function setSize(int $size): Unit {
		$this->size = $size;
		return $this;
	}

	public function setHealth(float $health): Unit {
		$this->health = $health;
		return $this;
	}

	public function setIsGuarding(bool $isGuarding): Unit {
		$this->isGuarding = $isGuarding;
		return $this;
	}

	public function setBattleRow(BattleRow $battleRow): Unit {
		$this->battleRow = $battleRow;
		return $this;
	}

	public function setIsHiding(bool $isHiding): Unit {
		$this->isHiding = $isHiding;
		return $this;
	}

	public function setIsLooting(bool $isLooting): Unit {
		$this->isLooting = $isLooting;
		return $this;
	}

	public function setDisguise(Party|false|null $party = null): Unit {
		if ($party) {
			if ($party === $this->Party()) {
				$this->disguiseAs = null;
			} else {
				$this->disguiseAs = $party->Id();
			}
		} else {
			$this->disguiseAs = $party;
		}
		return $this;
	}

	public function replaceId(Id $id): Unit {
		$oldId = $this->Id();
		$this->setId($id);
		$this->Party()->People()->replace($oldId, $id);
		$this->Region()->Residents()->replace($oldId, $id);
		$this->Construction()?->Inhabitants()->replace($oldId, $id);
		$this->Vessel()?->Passengers()->replace($oldId, $id);
		return $this;
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array &$data): void {
		parent::validateSerializedData($data);
		$this->validate($data, 'race', 'string');
		$this->validate($data, 'size', 'int');
		$this->validate($data, 'aura', '?array');
		$this->validate($data, 'health', 'float');
		$this->validate($data, 'isGuarding', 'bool');
		$this->validate($data, 'battleRow', 'int');
		$this->validate($data, 'isHiding', 'bool');
		$this->validate($data, 'isLooting', 'bool');
		$disguiseAs = $data['disguiseAs'];
		if (!is_bool($disguiseAs) || $disguiseAs) {
			$this->validate($data, 'disguiseAs', '?int');
		}
		$this->validate($data, 'inventory', 'array');
		$this->validate($data, 'treasury', 'array');
		$this->validate($data, 'knowledge', 'array');
		$this->validate($data, 'battleSpells', '?array');
	}
}
