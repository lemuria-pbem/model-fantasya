<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Item;

/**
 * A scene is an item of some landscape.
 */
class Scene extends Item
{
	public function __construct(Landscape $landscape, int $count = 1) {
		parent::__construct($landscape, $count);
	}

	public function Landscape(): Landscape {
		/** @var Landscape $landscape */
		$landscape = $this->getObject();
		return $landscape;
	}

	public function add(Scene $scene): static {
		$this->addItem($scene);

		return $this;
	}

	public function remove(Scene $scene): static {
		$this->removeItem($scene);

		return $this;
	}
}
