<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Serializable;

/**
 * Describes the capabilities of an Unicum.
 */
interface Composition extends Artifact, Commodity, Serializable
{
	public function supports(Practice $action): bool;
}