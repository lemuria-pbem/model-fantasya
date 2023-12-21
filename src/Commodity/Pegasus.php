<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity;

use Lemuria\Model\Fantasya\Animal;
use Lemuria\Model\Fantasya\Commodity\Trophy\PegasusFeather;
use Lemuria\Model\Fantasya\RawMaterial;
use Lemuria\Model\Fantasya\RawMaterialTrait;
use Lemuria\Model\Fantasya\Talent\Horsetaming;
use Lemuria\Model\Fantasya\Transport;
use Lemuria\Model\Fantasya\Trophy;
use Lemuria\Model\Fantasya\TrophySource;
use Lemuria\SingletonTrait;

/**
 * A pegasus.
 */
final class Pegasus implements Animal, RawMaterial, Transport, TrophySource
{
	use RawMaterialTrait;
	use SingletonTrait;

	private const int PAYLOAD = 20 * 100;

	private const int SPEED = 3;

	private const int WEIGHT = 50 * 100;

	private const int CRAFT = 2;

	private const string TROPHY = PegasusFeather::class;

	private Trophy $trophy;

	public function __construct() {
		$this->trophy = self::createTrophy(self::TROPHY);
	}

	public function Weight(): int {
		return self::WEIGHT;
	}

	public function Payload(): int {
		return self::PAYLOAD;
	}

	public function Speed(): int {
		return self::SPEED;
	}

	public function Trophy(): Trophy {
		return $this->trophy;
	}

	protected function getCraftTalent(): string {
		return Horsetaming::class;
	}

	protected function getCraftLevel(): int {
		return self::CRAFT;
	}
}
