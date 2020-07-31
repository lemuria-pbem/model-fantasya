<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity;

use Lemuria\Model\Lemuria\Artifact;
use Lemuria\Model\Lemuria\ArtifactTrait;
use Lemuria\Model\Lemuria\Commodity;
use Lemuria\Model\Lemuria\Factory\BuilderTrait;
use Lemuria\Model\Lemuria\Requirement;
use Lemuria\Model\Lemuria\Talent\Carriagemaking;
use Lemuria\Model\Lemuria\Transport;

/**
 * A carriage.
 */
final class Carriage implements Artifact, Commodity, Transport
{
	use ArtifactTrait;
	use BuilderTrait;

	private const CRAFT = 1;

	private const PAYLOAD = 120 * 100;

	private const SPEED = 2;

	private const WEIGHT = 40 * 100;

	private const WOOD = 5;

	private ?Requirement $craft;

	/**
	 * Get the maximum weight of payload.
	 *
	 * @return int
	 */
	public function Payload(): int {
		return self::PAYLOAD;
	}

	/**
	 * Get the speed when transporting.
	 *
	 * @return int
	 */
	public function Speed(): int {
		return self::SPEED;
	}

	/**
	 * Get the weight of a product.
	 *
	 * @return int
	 */
	public function Weight(): int {
		return self::WEIGHT;
	}

	/**
	 * Get the needed craft to create this artifact.
	 *
	 * @return Requirement
	 */
	public function getCraft(): Requirement {
		if (!$this->craft) {
			$carriageMaking = self::createTalent(Carriagemaking::class);
			$this->craft    = new Requirement($carriageMaking, self::CRAFT);
		}
		return $this->craft;
	}

	/**
	 * Get the material.
	 *
	 * @return array(Commodity=>int)
	 */
	protected function material(): array {
		return [Wood::class => self::WOOD];
	}
}
