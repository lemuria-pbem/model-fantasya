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

	public const TRADE = 1;

	public const EARN = 2;

	public const RESOURCES = 4;

	public const ENTER = 8;

	public const GIVE = 16;

	public const GUARD = 32;

	public const PERCEPTION = 64;

	public const DISGUISE = 128;

	public const SILVER = 256;

	public const FOOD = 512;

	public const COMBAT = 1024;

	public const ALL = 2047;

	private int $agreement = self::NONE;

	/**
	 * Check if an agreement is suitable for a contact relation.
	 */
	#[Pure] public static function isContactAgreement(#[ExpectedValues(valuesFromClass: self::class)] int $agreement): bool {
		return $agreement > self::NONE && $agreement < self::DISGUISE;
	}

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
