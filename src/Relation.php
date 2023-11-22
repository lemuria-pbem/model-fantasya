<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

/**
 * A relation to a party can be general or specific for a region.
 */
class Relation
{
	public final const int NONE = 0;

	public final const int TELL = 1;

	public final const int TRADE = 2;

	public final const int EARN = 4;

	public final const int RESOURCES = 8;

	public final const int ENTER = 16;

	public final const int MARKET = 32;

	public final const int GIVE = 64;

	public final const int PASS = 128;

	public final const int GUARD = 256;

	public final const int PERCEPTION = 512;

	public final const int DISGUISE = 1024;

	public final const int SILVER = 2048;

	public final const int FOOD = 4096;

	public final const int COMBAT = 8192;

	public final const int ALL = 16383;

	private int $agreement = self::NONE;

	/**
	 * Create a new relation, general or specific.
	 */
	public function __construct(private readonly Party $party, private readonly ?Region $region = null) {
	}

	public function Party(): Party {
		return $this->party;
	}

	public function Region(): ?Region {
		return $this->region;
	}

	public function Agreement(): int {
		return $this->agreement;
	}

	/**
	 * Check if a specific agreement is set.
	 */
	public function has(int $agreement): bool {
		return ($this->agreement & $agreement) === $agreement;
	}

	/**
	 * Replace agreements.
	 */
	public function set(int $agreement): static {
		$this->agreement = $this->validate($agreement);
		return $this;
	}

	/**
	 * Set a specific agreement.
	 */
	public function add(int $agreement): static {
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
	public function remove(int $agreement): static {
		if ($this->validate($agreement) !== self::NONE) {
			$agreement       = self::ALL ^ $agreement;
			$this->agreement &= $agreement;
		}
		return $this;
	}

	/**
	 * Get an identifier consisting of party and region.
	 */
	public function __toString(): string {
		return $this->party->Id() . '-' . ($this->region ? $this->region->Id() : '');
	}

	/**
	 * Validate agreement parameter.
	 */
	private function validate(int $agreement): int {
		if ($agreement < self::NONE || $agreement > self::ALL) {
			throw new \InvalidArgumentException('Invalid agreement: ' . $agreement);
		}
		return $agreement;
	}
}
