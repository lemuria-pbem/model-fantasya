<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use JetBrains\PhpStorm\ExpectedValues;
use JetBrains\PhpStorm\Pure;

/**
 * A relation to a party can be general or specific for a region.
 */
class Relation
{
	public const NONE = 0;

	public const TELL = 1;

	public const TRADE = 2;

	public const EARN = 4;

	public const RESOURCES = 8;

	public const ENTER = 16;

	public const GIVE = 32;

	public const GUARD = 64;

	public const PERCEPTION = 128;

	public const DISGUISE = 256;

	public const SILVER = 512;

	public const FOOD = 1024;

	public const COMBAT = 2048;

	public const ALL = 4095;

	private int $agreement = self::NONE;

	/**
	 * Create a new relation, general or specific.
	 */
	#[Pure] public function __construct(private Party $party, private ?Region $region = null) {
	}

	#[Pure] public function Party(): Party {
		return $this->party;
	}

	#[Pure] public function Region(): ?Region {
		return $this->region;
	}

	#[ExpectedValues(valuesFromClass: self::class)]
	#[Pure]
	public function Agreement(): int {
		return $this->agreement;
	}

	/**
	 * Check if a specific agreement is set.
	 */
	#[Pure] public function has(#[ExpectedValues(valuesFromClass: self::class)] int $agreement): bool {
		return ($this->agreement & $agreement) === $agreement;
	}

	/**
	 * Replace agreements.
	 */
	public function set(#[ExpectedValues(valuesFromClass: self::class)] int $agreement): Relation {
		$this->agreement = $this->validate($agreement);
		return $this;
	}

	/**
	 * Set a specific agreement.
	 */
	public function add(#[ExpectedValues(valuesFromClass: self::class)] int $agreement): Relation {
		if ($this->validate($agreement) === self::NONE) {
			$this->agreement = self::NONE;
		} else {
			$this->agreement |= $agreement;
		}
		return $this;
	}

	/**
	 * Unset a specific agreement.
	 */
	public function remove(#[ExpectedValues(valuesFromClass: self::class)] int $agreement): Relation {
		if ($this->validate($agreement) !== self::NONE) {
			$agreement       = self::ALL ^ $agreement;
			$this->agreement &= $agreement;
		}
		return $this;
	}

	/**
	 * Get an identifier consisting of party and region.
	 */
	#[Pure] public function __toString(): string {
		return $this->party->Id() . '-' . ($this->region ? $this->region->Id() : '');
	}

	/**
	 * Validate agreement parameter.
	 */
	private function validate(#[ExpectedValues(valuesFromClass: self::class)] int $agreement): int {
		if ($agreement < self::NONE || $agreement > self::ALL) {
			throw new \InvalidArgumentException('Invalid agreement: ' . $agreement);
		}
		return $agreement;
	}
}
