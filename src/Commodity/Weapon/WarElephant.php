<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use Lemuria\Model\Fantasya\Animal;
use Lemuria\Model\Fantasya\Commodity\Elephant;
use Lemuria\Model\Fantasya\Commodity\ElephantArmor;
use Lemuria\Model\Fantasya\Commodity\Wood;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Talent\Riding;
use Lemuria\Model\Fantasya\Talent\Weaponry;
use Lemuria\Model\Fantasya\Transport;
use Lemuria\SingletonTrait;

/**
 * A war elephant is a special weapon.
 */
final class WarElephant extends AbstractWeapon implements Animal, Transport
{
	use SingletonTrait;

	public const int WEIGHT = 300 * 100;

	/**
	 * @type array<int>
	 */
	public final const array DAMAGE = [1, 20, 4];

	private const int WOOD = 2;

	private const int ELEPHANT_ARMOR = 1;

	private const int ELEPHANT = 1;

	private const int CRAFT = 5;

	private const int HITS = 3;

	private const int PAYLOAD = 180 * 100;

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

	public function Payload(): int {
		return self::PAYLOAD;
	}

	public function Speed(): int {
		return self::SPEED;
	}

	public function getCraft(): Requirement {
		$weaponry = self::createTalent(Weaponry::class);
		return new Requirement($weaponry, self::CRAFT);
	}

	protected function material(): array {
		return [Wood::class => self::WOOD, ElephantArmor::class => self::ELEPHANT_ARMOR, Elephant::class => self::ELEPHANT];
	}

	protected function talent(): string {
		return Riding::class;
	}

}
