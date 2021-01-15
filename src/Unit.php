<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\ExpectedValues;
use JetBrains\PhpStorm\Pure;

use function Lemuria\getClass;
use Lemuria\Collectible;
use Lemuria\CollectibleTrait;
use Lemuria\Entity;
use Lemuria\Id;
use Lemuria\Lemuria;
use Lemuria\Model\Catalog;
use Lemuria\Model\Exception\NotRegisteredException;
use Lemuria\Model\Lemuria\Factory\BuilderTrait;
use Lemuria\Serializable;

/**
 * A unit consists of a number of persons of the same race.
 */
class Unit extends Entity implements Collectible
{
	use BuilderTrait;
	use CollectibleTrait;

	private Race $race;

	private int $size = 0;

	private bool $isGuarding = false;

	private int $battleRow = Combat::BYSTANDER;

	private ?int $camouflage = 0;

	private Id|bool|null $disguiseAs = false;

	private Goods $inventory;

	private Knowledge $knowledge;

	/**
	 * Get a Unit.
	 *
	 * @throws NotRegisteredException
	 */
	public static function get(Id $id): Unit {
		/* @var Unit $unit */
		$unit = Lemuria::Catalog()->get($id, Catalog::UNITS);
		return $unit;
	}

	/**
	 * Create a new unit.
	 */
	#[Pure] public function __construct() {
		$this->inventory = new Goods();
		$this->knowledge = new Knowledge();
	}

	/**
	 * Get a plain data array of the model's data.
	 *
	 * @return array
	 */
	#[ArrayShape([
		'id' => 'int', 'name' => 'string', 'description' => 'string', 'race' => 'string', 'size' => 'int',
		'isGuarding' => 'bool', 'battleRow' => 'int', 'camouflage' => 'int|null', 'disguiseAs' => 'int|null',
		'inventory' => 'array', 'knowledge' => 'array'
	])]
	#[Pure]
	public function serialize(): array {
		$data               = parent::serialize();
		$data['race']       = getClass($this->Race());
		$data['size']       = $this->Size();
		$data['isGuarding'] = $this->IsGuarding();
		$data['battleRow']  = $this->BattleRow();
		$data['camouflage'] = $this->Camouflage();
		$id                 = $this->disguiseAs;
		$data['disguiseAs'] = $id instanceof Id ? $id->Id() : $id;
		$data['inventory']  = $this->Inventory()->serialize();
		$data['knowledge']  = $this->Knowledge()->serialize();
		return $data;
	}

	/**
	 * Restore the model's data from serialized data.
	 */
	public function unserialize(array $data): Serializable {
		parent::unserialize($data);
		$this->setRace(self::createRace($data['race']));
		$this->setSize($data['size']);
		$this->setIsGuarding($data['isGuarding']);
		$this->setBattleRow($data['battleRow']);
		$this->setCamouflage($data['camouflage']);
		$id               = $data['disguiseAs'];
		$this->disguiseAs = is_int($id) ? new Id($id) : $id;
		$this->Inventory()->unserialize($data['inventory']);
		$this->Knowledge()->unserialize($data['knowledge']);
		return $this;
	}

	#[Pure] public function Catalog(): int {
		return Catalog::UNITS;
	}

	#[Pure] public function Inventory(): Goods {
		return $this->inventory;
	}

	#[Pure] public function Knowledge(): Knowledge {
		return $this->knowledge;
	}

	#[Pure] public function Race(): Race {
		return $this->race;
	}

	#[Pure] public function Size(): int {
		return $this->size;
	}

	#[Pure] public function IsGuarding(): bool {
		return $this->isGuarding;
	}

	#[Pure] public function BattleRow(): int {
		return $this->battleRow;
	}

	#[Pure] public function Camouflage(): ?int {
		return $this->camouflage;
	}

	public function Disguise(): ?Party {
		if ($this->disguiseAs instanceof Id) {
			return Party::get($this->disguiseAs);
		}
		if ($this->disguiseAs === false) {
			return $this->Party();
		}
		return null;
	}

	public function Party(): Party {
		/* @var Party $party */
		$party = $this->getCollector(__FUNCTION__);
		return $party;
	}

	public function Region(): Region {
		/* @var Region $region */
		$region = $this->getCollector(__FUNCTION__);
		return $region;
	}

	public function Construction(): ?Construction {
		if ($this->hasCollector(__FUNCTION__)) {
			/* @var Construction $construction */
			$construction = $this->getCollector(__FUNCTION__);
			return $construction;
		}
		return null;
	}

	public function Vessel(): ?Vessel {
		if ($this->hasCollector(__FUNCTION__)) {
			/* @var Vessel $vessel */
			$vessel = $this->getCollector(__FUNCTION__);
			return $vessel;
		}
		return null;
	}

	/**
	 * Get the total weight of this Unit including its inventory.
	 */
	#[Pure] public function Weight(): int {
		$weight = $this->Size() * $this->Race()->Weight();
		foreach ($this->Inventory() as $quantity/* @var Quantity $quantity */) {
			$weight += $quantity->Weight();
		}
		return $weight;
	}

	public function setRace(Race $race): Unit {
		$this->race = $race;
		return $this;
	}

	public function setSize(int $size): Unit {
		$this->size = $size;
		return $this;
	}

	public function setIsGuarding(bool $isGuarding): Unit {
		$this->isGuarding = $isGuarding;
		return $this;
	}

	/**
	 * @throws \InvalidArgumentException
	 */
	public function setBattleRow(#[ExpectedValues(valuesFromClass: Combat::class)] int $battleRow): Unit {
		if (!Combat::isBattleRow($battleRow)) {
			throw new \InvalidArgumentException('Invalid battle row value: ' . $battleRow);
		}
		$this->battleRow = $battleRow;
		return $this;
	}

	public function setCamouflage(?int $level): Unit {
		if (is_int($level) && $level < 0) {
			$level = 0;
		}
		$this->camouflage = $level;
		return $this;
	}

	public function setDisguise(?Party $party = null): Unit {
		if ($party) {
			if ($party === $this->Party()) {
				$this->disguiseAs = false;
			} else {
				$this->disguiseAs = $party->Id();
			}
		} else {
			$this->disguiseAs = null;
		}
		return $this;
	}

	public function replaceId(Id $id): Unit {
		$oldId = $this->Id();
		$this->setId($id);
		$this->Party()->People()->replace($oldId, $id);
		$this->Region()->Residents()->replace($oldId, $id);
		$construction = $this->Construction();
		if ($construction) {
			$construction->Inhabitants()->replace($oldId, $id);
		}
		$vessel = $this->Vessel();
		if ($vessel) {
			$vessel->Passengers()->replace($oldId, $id);
		}
		return $this;
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array (string=>mixed) $data
	 */
	protected function validateSerializedData(array &$data): void {
		parent::validateSerializedData($data);
		$this->validate($data, 'race', 'string');
		$this->validate($data, 'size', 'int');
		$this->validate($data, 'isGuarding', 'bool');
		$this->validate($data, 'battleRow', 'int');
		$this->validate($data, 'camouflage', '?int');
		$disguiseAs = $data['disguiseAs'];
		if (!is_bool($disguiseAs) || $disguiseAs) {
			$this->validate($data, 'camouflage', '?int');
		}
		$this->validate($data, 'inventory', 'array');
		$this->validate($data, 'knowledge', 'array');
	}
}
