<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Protection;

use Lemuria\Model\Fantasya\Commodity\Iron;
use Lemuria\Model\Fantasya\Shield;

/**
 * A tall shield made of iron.
 */
final class Ironshield extends AbstractProtection implements Shield
{
	public final const int WEIGHT = 2 * 100;

	public final const int BLOCK = 6;

	private const int CRAFT = 3;

	private const int IRON = 2;

	public function Weight(): int {
		return self::WEIGHT;
	}

	public function Block(): int {
		return self::BLOCK;
	}

	/**
	 */
	protected function material(): array {
		return [Iron::class => self::IRON];
	}

	protected function craft(): int {
		return self::CRAFT;
	}
}
