<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

interface Potion extends Artifact, Commodity
{
	/**
	 * The potion level.
	 */
	public function Level(): int;

	/**
	 * The effect duration of the potion.
	 */
	public function Weeks(): int;
}
