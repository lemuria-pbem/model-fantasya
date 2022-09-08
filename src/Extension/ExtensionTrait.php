<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Extension;

use function Lemuria\getClass;

trait ExtensionTrait
{
	public function __toString(): string {
		return getClass($this);
	}
}
