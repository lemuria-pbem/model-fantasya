<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Serializable;

/**
 * Describes the capabilities of an Unicum.
 */
interface Composition extends Artifact, Commodity, Serializable
{
	public function init(): static;

	public function supports(Practice $action): bool;

	public function register(Unicum $tenant): static;

	public function reshape(Unicum $tenant): static;

}
