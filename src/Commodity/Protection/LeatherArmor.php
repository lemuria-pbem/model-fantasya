<?php
/** @noinspection PhpIdempotentOperationInspection */
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Protection;

use Lemuria\Model\Fantasya\Armature;
use Lemuria\Model\Fantasya\Commodity\Elephant;

/**
 * An armor made of Elephant leather.
 */
final class LeatherArmor extends AbstractProtection implements Armature
{
	public final const int WEIGHT = 1 * 100;

	public final const int BLOCK = 4;

	private const int CRAFT = 3;

	private const int ELEPHANT = 1;

	public function Weight(): int {
		return self::WEIGHT;
	}

	public function Block(): int {
		return self::BLOCK;
	}

	/**
	 */
	protected function material(): array {
		return [Elephant::class => self::ELEPHANT];
	}

	protected function craft(): int {
		return self::CRAFT;
	}
}
