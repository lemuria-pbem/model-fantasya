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
use Lemuria\Model\Fantasya\Extension\BattleSpells;
use Lemuria\Model\Fantasya\Extension\Trades;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Talent\Magic;
use Lemuria\Model\Sized;
use Lemuria\Model\World\Direction;
use Lemuria\Validate;

/**
 * A unit consists of a number of persons of the same race.
 */
class Unit extends Entity implements Collectible, Collector, Sized
{
	use BuilderTrait;
	use CollectibleTrait;
	use CollectorTrait;
	use ExtensionTrait;

	private const string RACE = 'race';

	private const string SIZE = 'size';

	private const string AURA = 'aura';

	private const string HEALTH = 'health';

	private const string IS_GUARDING = 'isGuarding';

	private const string BATTLE_ROW = 'battleRow';

	private const string IS_HIDING = 'isHiding';

	private const string IS_LOOTING = 'isLooting';

	private const string IS_TRANSPORTING = 'isTransporting';

	private const string DISGUISE_AS = 'disguiseAs';

	private const string INVENTORY = 'inventory';

	private const string TREASURY = 'treasury';

	private const string KNOWLEDGE = 'knowledge';

	private const string BATTLE_SPELLS = 'battleSpells';

	private Race $race;

	private int $size = 0;

	private float $health = 1.0;

	private Direction|false $isGuarding = false;

	private BattleRow $battleRow = BattleRow::Bystander;

	private bool $isHiding = false;

	private bool $isLooting = true;

	private bool $isTransporting = false;

	private Id|false|null $disguiseAs = false;

	private readonly Resources $inventory;

	private readonly Treasury $treasury;

	private readonly Knowledge $knowledge;

	private ?Aura $aura = null;

	private bool $battleSpellsInitialized = false;

	/**
	 * @return array<Unit>
	 */
	public static function all(): array {
		return Lemuria::Catalog()->getAll(Domain::Unit);
	}

	/**
	 * Get a Unit.
	 *
	 * @throws NotRegisteredException
	 */
	public static function get(Id $id): self {
		/** @var Unit $unit */
		$unit = Lemuria::Catalog()->get($id, Domain::Unit);
		return $unit;
	}

	/**
	 * Create a new unit.
	 */
	public function __construct() {
		$this->inventory = new Resources();
		$this->treasury  = new Treasury($this);
		$this->knowledge = new Knowledge();
		$this->initExtensions($this);
	}

	public function Catalog(): Domain {
		return Domain::Unit;
	}

	public function Aura(): ?Aura {
		return $this->aura;
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
		return (bool)$this->isGuarding;
	}

	public function GuardDirection(): Direction {
		return $this->isGuarding ?: Direction::None;
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

	public function IsTransporting(): bool {
		return $this->isTransporting;
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

	public function BattleSpells(): ?BattleSpells {
		if ($this->Extensions()->offsetExists(BattleSpells::class)) {
			/** @var BattleSpells $battleSpells */
			$battleSpells = $this->Extensions()->offsetGet(BattleSpells::class);
			return $battleSpells;
		}
		if (!$this->battleSpellsInitialized) {
			$this->battleSpellsInitialized = true;
			if ($this->knowledge->offsetExists(Magic::class)) {
				$battleSpells = new BattleSpells();
				$this->Extensions()->add($battleSpells);
				return $battleSpells;
			}
		}
		return null;
	}

	public function Trades(): Trades {
		if ($this->Extensions()->offsetExists(Trades::class)) {
			/** @var Trades $trades */
			$trades = $this->Extensions()->offsetGet(Trades::class);
		} else {
			$trades = new Trades($this);
			$this->Extensions()->add($trades);
		}
		return $trades;
	}

	/**
	 * This method will be called by the Catalog after loading is finished; the Collector can initialize its collections
	 * then.
	 */
	public function collectAll(): static {
		$this->Treasury()->addCollectorsToAll();
		$this->Trades()->addCollectorsToAll();
		return $this;
	}

	public function serialize(): array {
		$data                        = parent::serialize();
		$data[self::RACE]            = getClass($this->Race());
		$data[self::SIZE]            = $this->Size();
		$data[self::AURA]            = $this->aura?->serialize();
		$data[self::HEALTH]          = $this->Health();
		$data[self::IS_GUARDING]     = $this->isGuarding ? $this->isGuarding->value : false;
		$data[self::BATTLE_ROW]      = $this->BattleRow();
		$data[self::IS_HIDING]       = $this->IsHiding();
		$data[self::IS_LOOTING]      = $this->IsLooting();
		$data[self::IS_TRANSPORTING] = $this->IsTransporting();
		$id                          = $this->disguiseAs;
		$data[self::DISGUISE_AS]     = $id instanceof Id ? $id->Id() : $id;
		$data[self::INVENTORY]       = $this->Inventory()->serialize();
		$data[self::TREASURY]        = $this->Treasury()->serialize();
		$data[self::KNOWLEDGE]       = $this->Knowledge()->serialize();
		$this->serializeExtensions($data);
		return $data;
	}

	/**
	 * Restore the model's data from serialized data.
	 */
	public function unserialize(array $data): static {
		parent::unserialize($data);
		$this->setRace(self::createRace($data[self::RACE]));
		$this->setSize($data[self::SIZE]);
		$this->setHealth($data[self::HEALTH]);
		$isGuarding = $data[self::IS_GUARDING];
		$this->setIsGuarding(is_string($isGuarding) ? Direction::from($isGuarding) : false);
		$this->setBattleRow(BattleRow::from($data[self::BATTLE_ROW]));
		$this->setIsHiding($data[self::IS_HIDING]);
		$this->setIsLooting($data[self::IS_LOOTING]);
		$this->setIsTransporting($data[self::IS_TRANSPORTING]);
		$id               = $data[self::DISGUISE_AS];
		$this->disguiseAs = is_int($id) ? new Id($id) : $id;
		$this->Inventory()->unserialize($data[self::INVENTORY]);
		$this->Treasury()->unserialize($data[self::TREASURY]);
		$this->Knowledge()->unserialize($data[self::KNOWLEDGE]);
		if (isset($data[self::AURA])) {
			$this->aura = new Aura();
			$this->aura->unserialize($data[self::AURA]);
		}
		$this->unserializeExtensions($data);
		return $this;
	}

	public function setAura(?Aura $aura): static {
		$this->aura = $aura;
		return $this;
	}

	public function setRace(Race $race): static {
		$this->race = $race;
		return $this;
	}

	public function setSize(int $size): static {
		$this->size = $size;
		return $this;
	}

	public function setHealth(float $health): static {
		$this->health = $health;
		return $this;
	}

	public function setIsGuarding(Direction|bool $isGuarding): static {
		if ($isGuarding === true) {
			$isGuarding = Direction::None;
		}
		$this->isGuarding = $isGuarding;
		return $this;
	}

	public function setBattleRow(BattleRow $battleRow): static {
		$this->battleRow = $battleRow;
		return $this;
	}

	public function setIsHiding(bool $isHiding): static {
		$this->isHiding = $isHiding;
		return $this;
	}

	public function setIsLooting(bool $isLooting): static {
		$this->isLooting = $isLooting;
		return $this;
	}

	public function setIsTransporting(bool $isTransporting): static {
		$this->isTransporting = $isTransporting;
		return $this;
	}

	public function setDisguise(Party|false|null $party = null): static {
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

	public function replaceId(Id $id): static {
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
	protected function validateSerializedData(array $data): void {
		parent::validateSerializedData($data);
		$this->validate($data, self::RACE, Validate::String);
		$this->validate($data, self::SIZE, Validate::Int);
		$this->validate($data, self::AURA, Validate::ArrayOrNull);
		$this->validate($data, self::HEALTH, Validate::Float);
		$isGuarding = $this->validateDataKey($data, self::IS_GUARDING);
		if ($isGuarding !== false) {
			$this->validateEnum($data, self::IS_GUARDING, Direction::class);
		}
		$this->validate($data, self::BATTLE_ROW, Validate::Int);
		$this->validate($data, self::IS_HIDING, Validate::Bool);
		$this->validate($data, self::IS_LOOTING, Validate::Bool);
		$this->validate($data, self::IS_TRANSPORTING, Validate::Bool);
		$disguiseAs = $this->validateDataKey($data, self::DISGUISE_AS);
		if (!is_bool($disguiseAs) || $disguiseAs) {
			$this->validate($data, self::DISGUISE_AS, Validate::IntOrNull);
		}
		$this->validate($data, self::INVENTORY, Validate::Array);
		$this->validate($data, self::TREASURY, Validate::Array);
		$this->validate($data, self::KNOWLEDGE, Validate::Array);
		$this->validateExtensions($data);
	}
}
