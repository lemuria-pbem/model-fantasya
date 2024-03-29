<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity;

use Lemuria\Model\Fantasya\Artifact;
use Lemuria\Model\Fantasya\ArtifactTrait;
use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Talent\Armory;

/**
 * War elephants need this armor.
 */
class ElephantArmor implements Artifact, Commodity
{
	use ArtifactTrait;
	use BuilderTrait;

	private const int CRAFT = 5;

	private const int WEIGHT = 50 * 100;

	private const int IRON = 10;

	private ?Requirement $craft = null;

	public function Weight(): int {
		return self::WEIGHT;
	}

	public function getCraft(): Requirement {
		if (!$this->craft) {
			$armory      = self::createTalent(Armory::class);
			$this->craft = new Requirement($armory, self::CRAFT);
		}
		return $this->craft;
	}

	protected function material(): array {
		return [Iron::class => self::IRON];
	}
}
