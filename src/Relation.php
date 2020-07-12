<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

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

	private Party $party;

	private ?Region $region;

	private int $agreement = self::NONE;

	/**
	 * Check if an agreement is suitable for a contact relation.
	 *
	 * @param int $agreement
	 * @return bool
	 */
	public static function isContactAgreement(int $agreement): bool {
		return $agreement > self::NONE && $agreement < self::DISGUISE;
	}

	/**
	 * Create a new relation, general or specific.
	 *
	 * @param Party $party
	 * @param Region|null $region
	 */
	public function __construct(Party $party, ?Region $region = null) {
		$this->party  = $party;
		$this->region = $region;
	}

	/**
	 * Get the party.
	 *
	 * @return Party
	 */
	public function Party(): Party {
		return $this->party;
	}

	/**
	 * Get the region.
	 *
	 * @return Region|null
	 */
	public function Region(): ?Region {
		return $this->region;
	}

	/**
	 * Get the agreement details.
	 *
	 * @return int
	 */
	public function Agreement(): int {
		return $this->agreement;
	}

	/**
	 * Check if a specific agreement is set.
	 *
	 * @param int $agreement
	 * @return bool
	 */
	public function has(int $agreement): bool {
		return ($this->agreement & $agreement) === $agreement;
	}

	/**
	 * Replace agreements.
	 *
	 * @param int $agreement
	 * @return Relation
	 */
	public function set(int $agreement): Relation {
		$this->agreement = $this->validate($agreement);
		return $this;
	}

	/**
	 * Set a specific agreement.
	 *
	 * @param int $agreement
	 * @return Relation
	 */
	public function add(int $agreement): Relation {
		if ($this->validate($agreement) === self::NONE) {
			$this->agreement = self::NONE;
		} else {
			$this->agreement |= $agreement;
		}
		return $this;
	}

	/**
	 * Unset a specific agreement.
	 *
	 * @param int $agreement
	 * @return Relation
	 */
	public function remove(int $agreement): Relation {
		if ($this->validate($agreement) !== self::NONE) {
			$agreement       = self::ALL ^ $agreement;
			$this->agreement &= $agreement;
		}
		return $this;
	}

	/**
	 * Get an identifier consisting of party and region.
	 *
	 * @return string
	 */
	public function __toString(): string {
		return $this->party->Id() . '-' . ($this->region ? $this->region->Id() : '');
	}

	/**
	 * Validate agreement parameter.
	 *
	 * @param int $agreement
	 * @return int
	 */
	private function validate(int $agreement): int {
		if ($agreement < self::NONE || $agreement > self::ALL) {
			throw new \InvalidArgumentException('Invalid agreement: ' . $agreement);
		}
		return $agreement;
	}
}
