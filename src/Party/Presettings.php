<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Party;

use Lemuria\Id;
use Lemuria\Model\Fantasya\Combat\BattleRow;
use Lemuria\Model\Fantasya\Party;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;

class Presettings implements Serializable
{
	use SerializableTrait;

	protected BattleRow $battleRow = BattleRow::BYSTANDER;

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
			'battleRow'  => $this->BattleRow()->value,
			'isHiding'   => $this->IsHiding(),
			'disguiseAs' => $this->disguiseAs instanceof Id ? $this->disguiseAs->Id() : $this->disguiseAs,
			'isLooting'  => $this->IsLooting(),
			'isRepeat'   => $this->IsRepeat()
		];
	}

	public function unserialize(array $data): Serializable {
		$this->validateSerializedData($data);
		$this->setBattleRow(BattleRow::from($data['battleRow']));
		$this->setIsHiding($data['isHiding']);
		$this->setIsLooting($data['isLooting']);
		$this->setIsRepeat($data['isRepeat']);
		$id               = $data['disguiseAs'];
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
	protected function validateSerializedData(array &$data): void {
		$this->validate($data, 'battleRow', 'int');
		$this->validate($data, 'isHiding', 'bool');
		$disguiseAs = $data['disguiseAs'];
		if (!is_bool($disguiseAs) || $disguiseAs) {
			$this->validate($data, 'disguiseAs', '?int');
		}
		$this->validate($data, 'isLooting', 'bool');
		$this->validate($data, 'isRepeat', 'bool');
	}
}
