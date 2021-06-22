<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

use Lemuria\Model\Fantasya\Spell;
use Lemuria\SingletonTrait;

abstract class AbstractSpell implements Spell
{
	use SingletonTrait;

	protected bool $isIncremental = true;

	public function IsIncremental(): bool {
		return $this->isIncremental;
	}
}
