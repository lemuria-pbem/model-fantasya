<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Pure;

use function Lemuria\getClass;
use Lemuria\Exception\UnserializeException;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;

class SpellGrade implements Serializable
{
	use BuilderTrait;
	use SerializableTrait;

	private BattleSpell $spell;

	private int $level;

	public function __construct(?BattleSpell $spell = null, ?int $level = null) {
		if ($spell && $level) {
			$this->spell = $spell;
			$this->level = $level;
		}
	}

	public function Spell(): BattleSpell {
		return $this->spell;
	}

	public function Level(): int {
		return $this->level;
	}

	#[Pure] public function serialize(): array {
		return [getClass($this->spell) => $this->level];
	}

	public function unserialize(array $data): Serializable {
		$this->validateSerializedData($data);
		$spell = self::createSpell(key($data));
		if ($spell instanceof BattleSpell) {
			$this->spell = $spell;
			$this->level = current($data);
			return $this;
		}
		throw new UnserializeException('No BattleSpell in SpellGrade data.');
	}

	/**
	 * @param array(string=>int) $data
	 */
	protected function validateSerializedData(array &$data): void {
		if (empty($data)) {
			throw new UnserializeException('SpellGrade must not have empty data.');
		}
		$key = key($data);
		if (!is_string($key)) {
			throw new UnserializeException('SpellGrade key must be a string.');
		}
		$this->validate($data, $key, 'int');
	}
}
