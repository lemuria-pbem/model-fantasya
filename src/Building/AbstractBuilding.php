<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use Lemuria\Exception\LemuriaException;
use Lemuria\Model\Fantasya\Building;
use Lemuria\Model\Fantasya\ArtifactTrait;
use Lemuria\Model\Fantasya\BuildingEffect;
use Lemuria\Model\Fantasya\Constraints;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Talent\Constructing;

/**
 * Base class for any building.
 */
abstract class AbstractBuilding implements Building
{
	use ArtifactTrait;
	use BuilderTrait;

	private ?Requirement $craft = null;

	private ?BuildingEffect $buildingEffect = null;

	/**
	 * Get the needed craft to create this artifact.
	 */
	public function getCraft(): Requirement {
		if (!$this->craft) {
			$talent      = self::createTalent(Constructing::class);
			$this->craft = new Requirement($talent, $this->Talent());
		}
		return $this->craft;
	}

	/**
	 * Get the best fitting building for given size of this building.
	 */
	public function correctBuilding(int $size): Building {
		$this->validateSize($size);
		return $this;
	}

	/**
	 * Get the best fitting size for given size of this building.
	 */
	public function correctSize(int $size): int {
		$this->validateSize($size);
		return $size;
	}

	/**
	 * Get the constraints for serialization.
	 */
	public function getConstraints(?Constraints $constraints): ?array {
		return $constraints?->serialize();
	}

	/**
	 * Set the constraints from serialized data.
	 */
	public function makeConstraints(?array $serialized): ?Constraints {
		return null;
	}

	public function BuildingEffect(): BuildingEffect {
		if (!$this->buildingEffect) {
			$this->buildingEffect = new BuildingEffect();
			$this->fill($this->buildingEffect);
		}
		return $this->buildingEffect;
	}

	protected function validateSize(int $size): void {
		if ($size < 0) {
			throw new LemuriaException('Given size must be positive.');
		}
	}

	protected function fill(BuildingEffect $buildingEffect): void {
	}
}
