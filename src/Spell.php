<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Singleton;

interface Spell extends Singleton
{
	/**
	 * Aura points needed for casting (fixed or per level).
	 */
	public function Aura(): int;

	/**
	 * The difficulty level (Magic talent level needed).
	 */
	public function Difficulty(): int;

	/**
	 * Are Aura points fixed or incremental?
	 */
	public function IsIncremental(): bool;

	/**
	 * Can be used to set the order of casting.
	 */
	public function Order(): int;
}
