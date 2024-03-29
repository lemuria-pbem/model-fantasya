<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Exception\LemuriaException;
use Lemuria\Model\Fantasya\Commodity\AbstractCommodity;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;
use Lemuria\SingletonSet;
use Lemuria\Validate;

class Loot implements Serializable
{
	use SerializableTrait;

	public final const int NOTHING = 0;

	public final const int ALL = 1;

	public final const int RAW_MATERIAL = 2;

	public final const int LUXURY = 4;

	public final const int TRANSPORT = 8;

	public final const int WEAPON = 16;

	public final const int PROTECTION = 32;

	public final const int HERB = 64;

	public final const int POTION = 128;

	public final const int TROPHY = 256;

	private const string GROUP = 'group';

	private const string CLASS_KEY = 'class';

	protected int $group = self::ALL;

	protected SingletonSet $class;

	public static function getGroup(Commodity $commodity): int {
		return match (true) {
			$commodity instanceof Weapon                             => self::WEAPON,
			$commodity instanceof Protection                         => self::PROTECTION,
			$commodity instanceof Luxury                             => self::LUXURY,
			AbstractCommodity::resources()->offsetExists($commodity) => self::RAW_MATERIAL,
			$commodity instanceof Transport                          => self::TRANSPORT,
			$commodity instanceof Herb                               => self::HERB,
			$commodity instanceof Potion                             => self::POTION,
			$commodity instanceof Trophy                             => self::TROPHY,
			default => self::NOTHING
		};
	}

	public function __construct() {
		$this->class = new SingletonSet();
	}

	public function Classes(): SingletonSet {
		return $this->class;
	}

	public function serialize(): array {
		return [
			self::GROUP => $this->group, self::CLASS_KEY => $this->class->serialize()
		];
	}

	public function unserialize(array $data): static {
		$this->validateSerializedData($data);
		$this->group = $data[self::GROUP];
		$this->class->unserialize($data[self::CLASS_KEY]);
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

	public function set(int $group): static {
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

	public function remove(int $group): static {
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

	public function wants(Commodity $commodity): bool {
		$wants = $this->isWhitelist();
		return $this->class->offsetExists($commodity) || $this->has(self::getGroup($commodity)) ? !$wants : $wants;
	}

	/**
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		$this->validate($data, self::GROUP, Validate::Int);
		$this->validate($data, self::CLASS_KEY, Validate::Array);
	}
}
