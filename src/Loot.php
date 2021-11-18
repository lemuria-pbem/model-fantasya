<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

use Lemuria\Exception\LemuriaException;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;
use Lemuria\SingletonSet;

class Loot implements Serializable
{
	use SerializableTrait;

	public const NOTHING = 0;

	public const ALL = 1;

	public const RAW_MATERIAL = 2;

	public const LUXURY = 4;

	public const TRANSPORT = 8;

	public const WEAPON = 16;

	public const PROTECTION = 32;

	public const HERB = 64;

	public const POTION = 128;

	public const TROPHY = 256;

	protected int $group = self::ALL;

	protected SingletonSet $class;

	#[Pure] public function __construct() {
		$this->class = new SingletonSet();
	}

	public function Classes(): SingletonSet {
		return $this->class;
	}

	#[ArrayShape(['group' => 'int', 'class' => 'array'])]
	#[Pure]
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
		} elseif ($group === self::ALL) {
			$this->group = self::ALL;
		} else {
			if ($this->isWhitelist()) {
				$this->group |= $group;
			} else {
				$this->group &= 2 * self::TROPHY - 1 - $group;
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
		} elseif ($group === self::ALL) {
			$this->group = self::NOTHING;
		} else {
			if ($this->isWhitelist()) {
				$this->group &= 2 * self::TROPHY - 1 - $group;
			} else {
				$this->group |= $group;
			}
		}
		return $this;
	}

	/**
	 * @param array (string=>mixed) &$data
	 */
	protected function validateSerializedData(array &$data): void {
		$this->validate($data, 'group', 'int');
		$this->validate($data, 'class', 'array');
	}
}
