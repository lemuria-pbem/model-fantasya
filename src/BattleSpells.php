<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Pure;

use Lemuria\Exception\LemuriaException;
use Lemuria\Exception\UnserializeException;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;

class BattleSpells implements \Countable, Serializable
{
	use SerializableTrait;

	protected array $spells = [BattleSpell::PREPARATION => null, BattleSpell::COMBAT => null];

	public function Preparation(): ?SpellGrade {
		return $this->spells[BattleSpell::PREPARATION];
	}

	public function Combat(): ?SpellGrade {
		return $this->spells[BattleSpell::COMBAT];
	}

	public function count() {
		$n = 0;
		foreach ($this->spells as $spell) {
			if ($spell) {
				$n++;
			}
		}
		return $n;
	}

	#[Pure] public function serialize(): array {
		$data = [];
		foreach ($this->spells as $phase => $spell /* @var SpellGrade|null $spell */) {
			$data[$phase] = $spell?->serialize();
		}
		return $data;
	}

	public function unserialize(array $data): Serializable {
		$this->validateSerializedData($data);
		foreach ($data as $phase => $spell) {
			$this->spells[$phase] = $this->unserializeBattleSpell($spell);
		}
		return $this;
	}

	public function has(BattleSpell $spell): bool {
		$phase = $spell->Phase();
		if (isset($this->spells[$phase])) {
			/** @var SpellGrade $spellGrade */
			$spellGrade = $this->spells[$phase];
			if ($spellGrade->Spell() === $spell) {
				return true;
			}
		}
		return false;
	}

	public function add(SpellGrade $spell): BattleSpells {
		$phase = $spell->Spell()->Phase();
		if (array_key_exists($phase, $this->spells)) {
			$this->spells[$phase] = $spell;
			return $this;
		}
		throw new LemuriaException('Invalid battle spell phase in ' . $spell->Spell() . '.');
	}

	public function remove(BattleSpell $spell): BattleSpells {
		if (!$this->has($spell)) {
			throw new LemuriaException('Battle spell not set: ' . $spell);
		}
		unset($this->spells[$spell->Phase()]);
		return $this;
	}

	/**
	 * @param array(string=>array)
	 */
	protected function validateSerializedData(array $data): void {
		if (count($data) !== 2) {
			throw new UnserializeException('Expected two SpellGrade objects.');
		}
		if (!array_key_exists(BattleSpell::PREPARATION, $data) || !array_key_exists(BattleSpell::COMBAT, $data)) {
			throw new UnserializeException('Invalid BattleSpell indices.');
		}
		$spellGrade = $data[BattleSpell::PREPARATION];
		if ($spellGrade !== null && is_array($spellGrade)) {
			throw new UnserializeException('Invalid BattleSpell defined.');
		}
		$spellGrade = $data[BattleSpell::COMBAT];
		if ($spellGrade !== null && is_array($spellGrade)) {
			throw new UnserializeException('Invalid BattleSpell defined.');
		}
	}

	private function unserializeBattleSpell(?array $data): ?SpellGrade {
		if (is_array($data)) {
			$spellGrade = new SpellGrade();
			$spellGrade->unserialize($data);
			return $spellGrade;
		}
		return null;
	}
}
