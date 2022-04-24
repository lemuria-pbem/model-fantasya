<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\ExpectedValues;
use JetBrains\PhpStorm\Pure;

/**
 * A relation to a party can be general or specific for a region.
 */
class Relation
{
	public final const NONE = 0;

	public final const TELL = 1;

	public final const TRADE = 2;

	public final const EARN = 4;

	public final const RESOURCES = 8;

	public final const ENTER = 16;

	public final const GIVE = 32;

	public final const PASS = 64;

	public final const GUARD = 128;

	public final const PERCEPTION = 256;

	public final const DISGUISE = 512;

	public final const SILVER = 1024;

	public final const FOOD = 2048;

	public final const COMBAT = 4096;

	public final const ALL = 8191;

	private int $agreement = self::NONE;

	/**
	 * Create a new relation, general or specific.
	 */
	#[Pure] public function __construct(private readonly Party $party, private readonly ?Region $region = null) {
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
