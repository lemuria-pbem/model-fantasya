<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Pure;

use function Lemuria\getClass;

class BuildingEffect
{
	/**
	 * @var array(string=>array)
	 */
	protected array $effects = [];

	public function add(Modification $modification): BuildingEffect {
		$talent = getClass($modification->Talent());
		$this->effects[$talent] = $modification;
		return $this;
	}

	#[Pure] public function getEffect(Talent $talent): ?Modification {
		$talent = getClass($talent);
		return $this->effects[$talent] ?? null;
	}
}
