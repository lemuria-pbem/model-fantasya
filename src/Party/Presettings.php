<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Party;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

use Lemuria\Id;
use Lemuria\Model\Fantasya\Combat\BattleRow;
use Lemuria\Model\Fantasya\Party;
use Lemuria\Serializable;

class Presettings implements Serializable
{
	protected BattleRow $battleRow = BattleRow::BYSTANDER;

	protected Id|false|null $disguiseAs = false;

	protected bool $isHiding = false;

	protected bool $isLooting = true;

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

	#[ArrayShape(['battleRow' => 'int', 'disguiseAs' => 'int|false|null', 'isHiding' => 'bool', 'isLooting' => 'bool'])]
	#[Pure] public function serialize(): array {
		return [
			'battleRow'  => $this->BattleRow(),
			'isHiding'   => $this->IsHiding(),
			'disguiseAs' => $this->disguiseAs instanceof Id ? $this->disguiseAs->Id() : $this->disguiseAs,
			'isLooting'  => $this->IsLooting()
		];
	}

	public function unserialize(array $data): Serializable {
		$this->setBattleRow(BattleRow::from($data['battleRow']));
		$this->setIsHiding($data['isHiding']);
		$this->setIsLooting($data['isLooting']);
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
}
