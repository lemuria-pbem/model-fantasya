<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use JetBrains\PhpStorm\Pure;

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
final class WarElephant extends AbstractWeapon implements Transport
{
	use SingletonTrait;

	public const WEIGHT = 300 * 100;

	public final const DAMAGE = [1, 20, 4];

	private const WOOD = 2;

	private const ELEPHANT_ARMOR = 1;

	private const ELEPHANT = 1;

	private const CRAFT = 5;

	private const HITS = 3;

	private const PAYLOAD = 180 * 100;

	private const SPEED = 1;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	#[Pure] public function Damage(): Damage {
		return new Damage(...self::DAMAGE);
	}

	#[Pure] public function Hits(): int {
		return self::HITS;
	}

	#[Pure] public function Payload(): int {
		return self::PAYLOAD;
	}

	#[Pure] public function Speed(): int {
		return self::SPEED;
	}

	public function getCraft(): Requirement {
		$weaponry = self::createTalent(Weaponry::class);
		return new Requirement($weaponry, self::CRAFT);
	}

	/** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
	#[Pure] protected function material(): array {
		return [Wood::class => self::WOOD, ElephantArmor::class => self::ELEPHANT_ARMOR, Elephant::class => self::ELEPHANT];
	}

	#[Pure] protected function talent(): string {
		return Riding::class;
	}

}
