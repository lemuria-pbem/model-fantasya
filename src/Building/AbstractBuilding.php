<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use Lemuria\Exception\LemuriaException;
use Lemuria\Model\Fantasya\Building;
use Lemuria\Model\Fantasya\ArtifactTrait;
use Lemuria\Model\Fantasya\BuildingEffect;
use Lemuria\Model\Fantasya\Commodity\Iron;
use Lemuria\Model\Fantasya\Commodity\Stone;
use Lemuria\Model\Fantasya\Commodity\Wood;
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

	/**
	 * @type array<string, true>
	 */
	private const array STRUCTURE_MATERIAL = [Wood::class => true, Stone::class => true, Iron::class => true];

	private ?Requirement $craft = null;

	private ?BuildingEffect $buildingEffect = null;

	private ?int $structurePoints = null;

	public function MaxSize(): int {
		return Building::IS_UNLIMITED;
	}

	public function BuildingEffect(): BuildingEffect {
		if (!$this->buildingEffect) {
			$this->buildingEffect = new BuildingEffect();
			$this->fill($this->buildingEffect);
		}
		return $this->buildingEffect;
	}

	public function StructurePoints(): int {
		if ($this->structurePoints === null) {
			$this->structurePoints = 0;
			foreach ($this->getMaterial() as $quantity) {
				$commodity = $quantity->Commodity();
				if (isset(self::STRUCTURE_MATERIAL[$commodity::class])) {
					$this->structurePoints += $quantity->Count();
				}
			}
		}
		return $this->structurePoints;
	}

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

	protected function validateSize(int $size): void {
		if ($size < 0) {
			throw new LemuriaException('Given size must be positive.');
		}
	}

	protected function fill(BuildingEffect $buildingEffect): void {
	}
}
