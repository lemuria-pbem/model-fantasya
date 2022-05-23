<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Protection;

use Lemuria\Model\Fantasya\Armature;
use Lemuria\Model\Fantasya\Commodity\Iron;

/**
 * A full body armor made of iron.
 */
final class Armor extends AbstractProtection implements Armature
{
	public final const WEIGHT = 4 * 100;

	public final const BLOCK = 7;

	private const CRAFT = 4;

	private const IRON = 5;

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
