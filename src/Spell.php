<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Singleton;

interface Spell extends Singleton
{
	public function Difficulty(): int;
}
