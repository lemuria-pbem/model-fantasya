<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Extension;

use function Lemuria\getClass;

use Lemuria\Model\Fantasya\Extension;

abstract class AbstractExtension implements Extension
{
	public function __toString(): string {
		return getClass($this);
	}
}
