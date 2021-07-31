<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Model\Fantasya\Factory\BuilderTrait;

trait RawMaterialTrait
{
	use BuilderTrait;

	private ?Requirement $requirement = null;

	/**
	 * Check if this raw material is available in infinite amounts.
	 */
	public function IsInfinite(): bool {
		return false;
	}

	/**
	 * Get the required Talent to produce this raw material.
	 */
	public function getCraft(): Requirement {
		if (!$this->requirement) {
			$this->requirement = new Requirement(self::createTalent($this->getCraftTalent()), $this->getCraftLevel());
		}
		return $this->requirement;
	}

	abstract protected function getCraftTalent(): string;

	protected function getCraftLevel(): int {
		return 1;
	}
}
