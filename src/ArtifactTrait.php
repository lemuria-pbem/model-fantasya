<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use JetBrains\PhpStorm\Pure;

use Lemuria\Lemuria;
use Lemuria\SingletonTrait;

/**
 * Common implementation of an Artifact.
 */
trait ArtifactTrait
{
	use SingletonTrait;

	private ?Resources $material = null;

	/**
	 * Get the list of material needed to create the artifact.
	 */
	public function getMaterial(): Resources {
		if (!$this->material) {
			$this->material = new Resources();
			foreach ($this->material() as $product => $quantity) {
				$commodity = Lemuria::Builder()->create($product);
				/* @var Commodity $commodity */
				$this->material->add(new Quantity($commodity, $quantity));
			}
		}
		return $this->material;
	}

	/**
	 * Get the material.
	 *
	 * @return array(string=>int)
	 */
	#[Pure] abstract protected function material(): array;
}
