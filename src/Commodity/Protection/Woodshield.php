<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Protection;

use Lemuria\Model\Fantasya\Commodity\Wood;
use Lemuria\Model\Fantasya\Shield;

/**
 * A handy shield made of wood.
 */
final class Woodshield extends AbstractProtection implements Shield
{
	public final const int WEIGHT = 2 * 100;

	public final const int BLOCK = 4;

	private const int CRAFT = 2;

	private const int WOOD = 1;

	public function Weight(): int {
		return self::WEIGHT;
	}

	public function Block(): int {
		return self::BLOCK;
	}

	/**
	 */
	protected function material(): array {
		return [Wood::class => self::WOOD];
	}

	protected function craft(): int {
		return self::CRAFT;
	}
}
