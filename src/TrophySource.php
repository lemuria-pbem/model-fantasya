<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

interface TrophySource
{
	/**
	 * Get the trophy that can be gained.
	 */
	public function Trophy(): ?Trophy;
}
