<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Composition;

use function Lemuria\getClass;
use Lemuria\Lemuria;
use Lemuria\Model\Fantasya\Animal;
use Lemuria\Model\Fantasya\Practice;
use Lemuria\Model\Fantasya\Race;
use Lemuria\Model\Fantasya\Resources;
use Lemuria\Model\Fantasya\Talent\NullTalent;
use Lemuria\Model\Fantasya\Unicum;
use Lemuria\Validate;

class Carcass extends AbstractComposition
{
	private const string CREATURE = 'creature';

	private const string INVENTORY = 'inventory';

	protected Animal|Race|null $creature = null;

	protected Resources $inventory;

	public function __construct() {
		$this->inventory = new Resources();
	}

	public function Weight(): int {
		return $this->creature->Weight();
	}

	public function Creature(): Animal|Race|null {
		return $this->creature;
	}

	public function Inventory(): Resources {
		return $this->inventory;
	}

	public function init(): static {
		$this->inventory->clear();
		return parent::init();
	}

	public function serialize(): array {
		return [self::CREATURE => getClass($this->creature), self::INVENTORY => $this->inventory->serialize()];
	}

	public function unserialize(array $data): static {
		$this->validateSerializedData($data);
		$creature = Lemuria::Builder()->create($data[self::CREATURE]);
		if ($creature instanceof Animal || $creature instanceof Race) {
			$this->creature = $creature;
		}
		$this->inventory->unserialize($data[self::INVENTORY]);
		return $this;
	}

	public function supports(Practice $action): bool {
		return match($action) {
			Practice::Take, Practice::Read, Practice::Destroy => true,
			default                                           => false
		};
	}

	public function register(Unicum $tenant): static {
		$this->property($tenant)->creature  = $this->creature;
		$this->property($tenant)->inventory = $this->inventory->getClone();
		return $this;
	}

	public function reshape(Unicum $tenant): static {
		$this->creature  = $this->property($tenant)->creature;
		$this->inventory = $this->property($tenant)->inventory;
		return $this;
	}

	public function setCreature(Animal|Race $creature): Carcass {
		$this->creature = $creature;
		return $this;
	}

	public function setInventory(Resources $inventory): Carcass {
		$this->inventory = $inventory;
		return $this;
	}

	/**
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		$this->validate($data, self::CREATURE, Validate::String);
		$this->validate($data, self::INVENTORY, Validate::Array);
	}

	protected function material(): array {
		return [];
	}

	protected function talent(): string {
		return NullTalent::class;
	}
}
