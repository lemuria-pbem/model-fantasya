<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Exception\SingletonException;
use Lemuria\SingletonSet;

class SpellBook extends SingletonSet
{
	protected function validateSingleton(mixed $singleton): void {
		if (!($singleton instanceof Spell)) {
			throw new SingletonException($singleton, 'spell');
		}
	}
}
