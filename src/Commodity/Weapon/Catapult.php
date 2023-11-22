<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use Lemuria\Model\Fantasya\Commodity\Wood;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Talent\Carriagemaking;
use Lemuria\Model\Fantasya\Talent\Catapulting;
use Lemuria\Model\Fantasya\Transport;

/**
 * A catapult.
 */
final class Catapult extends AbstractWeapon implements Transport
{
	public final const int WEIGHT = 100 * 100;

	/**
	 * @type array<int>
	 */
	private const array DAMAGE = [3, 10, 5];

	private const int WOOD = 10;

	private const int CRAFT = 3;

	private const int HITS = 3;

	private const int INTERVAL = 5;

	private const int PAYLOAD = 10 * 100;

	private const int SPEED = 1;

	public function Weight(): int {
		return self::WEIGHT;
	}

	public function Damage(): Damage {
		return new Damage(...self::DAMAGE);
	}

	public function Hits(): int {
		return self::HITS;
	}

	public function Interval(): int {
		return self::INTERVAL;
	}

	public function getCraft(): Requirement {
		$carriagemaking = self::createTalent(Carriagemaking::class);
		return new Requirement($carriagemaking, self::CRAFT);
	}

	public function Payload(): int {
		return self::PAYLOAD;
	}

	public function Speed(): int {
		return self::SPEED;
	}

	protected function material(): array {
		return [Wood::class => self::WOOD];
	}

	protected function talent(): string {
		return Catapulting::class;
	}
}
