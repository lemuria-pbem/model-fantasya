<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Pure;

use function Lemuria\getClass;

class TerrainEffect
{
	/**
	 * @var array(string=>array)
	 */
	protected array $effects = [];

	public function add(Landscape $landscape, Modification $modification): TerrainEffect {
		$landscape = getClass($landscape);
		$talent    = getClass($modification->Talent());
		$this->effects[$landscape][$talent] = $modification;
		return $this;
	}

	#[Pure] public function getEffect(Landscape $landscape, Talent $talent): ?Modification {
		$landscape = getClass($landscape);
		$talent    = getClass($talent);
		return $this->effects[$landscape][$talent] ?? null;
	}
}
