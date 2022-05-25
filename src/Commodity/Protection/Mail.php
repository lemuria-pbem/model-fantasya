<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Protection;

use Lemuria\Model\Fantasya\Armature;
use Lemuria\Model\Fantasya\Commodity\Iron;

/**
 * A chain mail.
 */
final class Mail extends AbstractProtection implements Armature
{
	public final const WEIGHT = 2 * 100;

	public final const BLOCK = 5;

	private const CRAFT = 3;

	private const IRON = 3;

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
