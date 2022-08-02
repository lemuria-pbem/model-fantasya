<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Exception\LemuriaException;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;
use Lemuria\SingletonSet;

class Loot implements Serializable
{
	use SerializableTrait;

	public final const NOTHING = 0;

	public final const ALL = 1;

	public final const RAW_MATERIAL = 2;

	public final const LUXURY = 4;

	public final const TRANSPORT = 8;

	public final const WEAPON = 16;

	public final const PROTECTION = 32;

	public final const HERB = 64;

	public final const POTION = 128;

	public final const TROPHY = 256;

	protected int $group = self::ALL;

	protected SingletonSet $class;

	public function __construct() {
		$this->class = new SingletonSet();
	}

	public function Classes(): SingletonSet {
		return $this->class;
	}

	public function serialize(): array {
		return [
			'group' => $this->group, 'class' => $this->class->serialize()
		];
	}

	public function unserialize(array $data): Serializable {
		$this->validateSerializedData($data);
		$this->group = $data['group'];
		$this->class->unserialize($data['class']);
		return $this;
	}

	public function isWhitelist(): bool {
		return $this->has(self::ALL);
	}

	public function has(int $group): bool {
		if ($group < self::NOTHING) {
			throw new LemuriaException();
		}
		if ($group === self::NOTHING) {
			return ($this->group & self::ALL) === self::NOTHING;
		}
		return ($this->group & $group) === $group;
	}

	public function set(int $group): Loot {
		if ($group < self::NOTHING) {
			throw new LemuriaException();
		}
		if ($group === self::NOTHING) {
			$this->group = self::NOTHING;
			$this->Classes()->clear();
		} elseif ($group === self::ALL) {
			$this->group = self::ALL;
			$this->Classes()->clear();
		} else {
			if ($this->isWhitelist()) {
				$this->group &= 2 * self::TROPHY - 1 - $group;
			} else {
				$this->group |= $group;
			}
		}
		return $this;
	}

	public function remove(int $group): Loot {
		if ($group < self::NOTHING) {
			throw new LemuriaException();
		}
		if ($group === self::NOTHING) {
			$this->group = self::ALL;
			$this->Classes()->clear();
		} elseif ($group === self::ALL) {
			$this->group = self::NOTHING;
			$this->Classes()->clear();
		} else {
			if ($this->isWhitelist()) {
				$this->group |= $group;
			} else {
				$this->group &= 2 * self::TROPHY - 1 - $group;
			}
		}
		return $this;
	}

	/**
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array &$data): void {
		$this->validate($data, 'group', 'int');
		$this->validate($data, 'class', 'array');
	}
}
