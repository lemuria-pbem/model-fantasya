<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Protection;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Armature;
use Lemuria\Model\Fantasya\Commodity\Iron;

/**
 * A chain mail.
 */
final class Mail extends AbstractProtection implements Armature
{
	private const CRAFT = 3;

	private const WEIGHT = 2 * 100;

	private const IRON = 3;

	private const BLOCK = 5;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	#[Pure] public function Block(): int {
		return self::BLOCK;
	}

	/**
	 * @noinspection PhpArrayShapeAttributeCanBeAddedInspection
	 */
	#[Pure] protected function material(): array {
		return [Iron::class => self::IRON];
	}

	#[Pure] protected function craft(): int {
		return self::CRAFT;
	}
}