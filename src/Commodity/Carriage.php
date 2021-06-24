<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Artifact;
use Lemuria\Model\Fantasya\ArtifactTrait;
use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Talent\Carriagemaking;
use Lemuria\Model\Fantasya\Transport;

/**
 * A carriage.
 */
final class Carriage implements Artifact, Commodity, Transport
{
	use ArtifactTrait;
	use BuilderTrait;

	private const CRAFT = 1;

	private const PAYLOAD = 140 * 100;

	private const SPEED = 2;

	private const WEIGHT = 40 * 100;

	private const WOOD = 5;

	private ?Requirement $craft = null;

	#[Pure] public function Payload(): int {
		return self::PAYLOAD;
	}

	#[Pure] public function Speed(): int {
		return self::SPEED;
	}

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	public function getCraft(): Requirement {
		if (!$this->craft) {
			$carriageMaking = self::createTalent(Carriagemaking::class);
			$this->craft    = new Requirement($carriageMaking, self::CRAFT);
		}
		return $this->craft;
	}

	/** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
	#[Pure] protected function material(): array {
		return [Wood::class => self::WOOD];
	}
}
