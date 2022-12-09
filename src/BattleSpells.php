<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Exception\LemuriaException;
use Lemuria\Exception\UnserializeException;
use Lemuria\Model\Fantasya\Combat\Phase;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;

class BattleSpells implements \Countable, Serializable
{
	use SerializableTrait;

	/**
	 * @var array<int, SpellGrade>
	 */
	protected array $spells;

	public function __construct() {
		$this->spells = [Phase::Preparation->value => null, Phase::Combat->value => null];
	}

	public function __clone(): void {
		foreach (array_keys($this->spells) as $phase) {
			$spell = $this->spells[$phase];
			if ($spell) {
				$this->spells[$phase] = new SpellGrade($spell->Spell(), $spell->Level());
			}
		}
	}

	public function Preparation(): ?SpellGrade {
		return $this->spells[Phase::Preparation->value];
	}

	public function Combat(): ?SpellGrade {
		return $this->spells[Phase::Combat->value];
	}

	public function count(): int {
		$n = 0;
		foreach ($this->spells as $spell) {
			if ($spell) {
				$n++;
			}
		}
		return $n;
	}

	public function serialize(): array {
		$data = [];
		foreach ($this->spells as $phase => $spell) {
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
		$phase = $spell->Phase()->value;
		if (isset($this->spells[$phase])) {
			$spellGrade = $this->spells[$phase];
			if ($spellGrade->Spell() === $spell) {
				return true;
			}
		}
		return false;
	}

	public function add(SpellGrade $spell): BattleSpells {
		$phase = $spell->Spell()->Phase()->value;
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
		unset($this->spells[$spell->Phase()->value]);
		return $this;
	}

	/**
	 * @param array<string, array> $data
	 */
	protected function validateSerializedData(array $data): void {
		if (count($data) !== 2) {
			throw new UnserializeException('Expected two SpellGrade objects.');
		}
		if (!array_key_exists(Phase::Preparation->value, $data) || !array_key_exists(Phase::Combat->value, $data)) {
			throw new UnserializeException('Invalid BattleSpell indices.');
		}
		$spellGrade = $data[Phase::Preparation->value];
		if ($spellGrade !== null && !is_array($spellGrade)) {
			throw new UnserializeException('Invalid BattleSpell defined.');
		}
		$spellGrade = $data[Phase::Combat->value];
		if ($spellGrade !== null && !is_array($spellGrade)) {
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
