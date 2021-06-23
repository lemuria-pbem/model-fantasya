<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Exception\LemuriaException;
use Lemuria\Exception\UnserializeException;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;

class BattleSpells implements Serializable
{
	use SerializableTrait;

	protected ?SpellGrade $preparation = null;

	protected ?SpellGrade $combat = null;

	public function Preparation(): ?SpellGrade {
		return $this->preparation;
	}

	public function Combat(): ?SpellGrade {
		return $this->combat;
	}

	public function serialize(): array {
		$data = [BattleSpell::PREPARATION => null, BattleSpell::COMBAT => null];
		if ($this->preparation) {
			$data[$this->preparation->Spell()->Phase()] = $this->preparation->serialize();
		}
		if ($this->combat) {
			$data[$this->combat->Spell()->Phase()] = $this->combat->serialize();
		}
		ksort($data);
		return $data;
	}

	public function unserialize(array $data): Serializable {
		$this->validateSerializedData($data);
		$this->preparation = $this->unserializeBattleSpell($data[BattleSpell::PREPARATION]);
		$this->combat      = $this->unserializeBattleSpell($data[BattleSpell::COMBAT]);
		return $this;
	}

	public function setPreparation(?SpellGrade $spell): BattleSpells {
		if ($spell->Spell()->Phase() !== BattleSpell::PREPARATION) {
			throw new LemuriaException('Invalid battle spell for preparation phase.');
		}
		$this->preparation = $spell;
		return $this;
	}

	public function setCombat(?SpellGrade $spell): BattleSpells {
		if ($spell->Spell()->Phase() !== BattleSpell::COMBAT) {
			throw new LemuriaException('Invalid battle spell for combat phase.');
		}
		$this->combat = $spell;
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
