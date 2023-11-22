<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Party;

use Lemuria\Id;
use Lemuria\Model\Fantasya\Combat\BattleRow;
use Lemuria\Model\Fantasya\Party;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;
use Lemuria\Validate;

class Presettings implements Serializable
{
	use SerializableTrait;

	private const string BATTLE_ROW = 'battleRow';

	private const string IS_HIDING = 'isHiding';

	private const string DISGUISE_AS = 'disguiseAs';

	private const string IS_LOOTING = 'isLooting';

	private const string IS_REPEAT = 'isRepeat';

	private const string EXPLORING = 'exploring';

	protected BattleRow $battleRow = BattleRow::Bystander;

	protected Id|false|null $disguiseAs = false;

	protected bool $isHiding = false;

	protected bool $isLooting = true;

	protected bool $isRepeat = false;

	protected Exploring $exploring = Exploring::Not;

	public function BattleRow(): BattleRow {
		return $this->battleRow;
	}

	public function Disguise(): Party|false|null {
		if ($this->disguiseAs instanceof Id) {
			return Party::get($this->disguiseAs);
		}
		return $this->disguiseAs;
	}

	public function IsHiding(): bool {
		return $this->isHiding;
	}

	public function IsLooting(): bool {
		return $this->isLooting;
	}

	public function IsRepeat(): bool {
		return $this->isRepeat;
	}

	public function Exploring(): Exploring {
		return $this->exploring;
	}

	public function serialize(): array {
		return [
			self::BATTLE_ROW  => $this->BattleRow()->value,
			self::IS_HIDING   => $this->IsHiding(),
			self::DISGUISE_AS => $this->disguiseAs instanceof Id ? $this->disguiseAs->Id() : $this->disguiseAs,
			self::IS_LOOTING  => $this->IsLooting(),
			self::IS_REPEAT   => $this->IsRepeat(),
			self::EXPLORING   => $this->exploring->name
		];
	}

	public function unserialize(array $data): static {
		$this->validateSerializedData($data);
		$this->setBattleRow(BattleRow::from($data[self::BATTLE_ROW]));
		$this->setIsHiding($data[self::IS_HIDING]);
		$this->setIsLooting($data[self::IS_LOOTING]);
		$this->setIsRepeat($data[self::IS_REPEAT]);
		$id               = $data[self::DISGUISE_AS];
		$this->disguiseAs = is_int($id) ? new Id($id) : $id;
		$this->setExploring(Exploring::parse($data[self::EXPLORING]));
		return $this;
	}

	public function setBattleRow(BattleRow $battleRow): static {
		$this->battleRow = $battleRow;
		return $this;
	}

	public function setDisguise(Id|false|null $disguise = null): static {
		$this->disguiseAs = $disguise;
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

	public function setIsRepeat(bool $isRepeat): static {
		$this->isRepeat = $isRepeat;
		return $this;
	}

	public function setExploring(Exploring $exploring): static {
		$this->exploring = $exploring;
		return $this;
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		$this->validate($data, self::BATTLE_ROW, Validate::Int);
		$this->validate($data, self::IS_HIDING, Validate::Bool);
		$disguiseAs = $data[self::DISGUISE_AS];
		if (!is_bool($disguiseAs) || $disguiseAs) {
			$this->validate($data, self::DISGUISE_AS, Validate::IntOrNull);
		}
		$this->validate($data, self::IS_LOOTING, Validate::Bool);
		$this->validate($data, self::IS_REPEAT, Validate::Bool);
		$this->validateEnum($data, self::EXPLORING, Exploring::class);
	}
}
