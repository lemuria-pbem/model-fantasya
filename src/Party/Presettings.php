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

	private const BATTLE_ROW = 'battleRow';

	private const IS_HIDING = 'isHiding';

	private const DISGUISE_AS = 'disguiseAs';

	private const IS_LOOTING = 'isLooting';

	private const IS_REPEAT = 'isRepeat';

	protected BattleRow $battleRow = BattleRow::Bystander;

	protected Id|false|null $disguiseAs = false;

	protected bool $isHiding = false;

	protected bool $isLooting = true;

	protected bool $isRepeat = false;

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

	public function serialize(): array {
		return [
			self::BATTLE_ROW  => $this->BattleRow()->value,
			self::IS_HIDING   => $this->IsHiding(),
			self::DISGUISE_AS => $this->disguiseAs instanceof Id ? $this->disguiseAs->Id() : $this->disguiseAs,
			self::IS_LOOTING  => $this->IsLooting(),
			self::IS_REPEAT   => $this->IsRepeat()
		];
	}

	public function unserialize(array $data): Serializable {
		$this->validateSerializedData($data);
		$this->setBattleRow(BattleRow::from($data[self::BATTLE_ROW]));
		$this->setIsHiding($data[self::IS_HIDING]);
		$this->setIsLooting($data[self::IS_LOOTING]);
		$this->setIsRepeat($data[self::IS_REPEAT]);
		$id               = $data[self::DISGUISE_AS];
		$this->disguiseAs = is_int($id) ? new Id($id) : $id;
		return $this;
	}

	public function setBattleRow(BattleRow $battleRow): Presettings {
		$this->battleRow = $battleRow;
		return $this;
	}

	public function setDisguise(Id|false|null $disguise = null): Presettings {
		$this->disguiseAs = $disguise;
		return $this;
	}

	public function setIsHiding(bool $isHiding): Presettings {
		$this->isHiding = $isHiding;
		return $this;
	}

	public function setIsLooting(bool $isLooting): Presettings {
		$this->isLooting = $isLooting;
		return $this;
	}

	public function setIsRepeat(bool $isRepeat): Presettings {
		$this->isRepeat = $isRepeat;
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
	}
}
