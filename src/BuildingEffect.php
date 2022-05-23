<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

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

	public function getEffect(Talent $talent): ?Modification {
		$talent = getClass($talent);
		return $this->effects[$talent] ?? null;
	}
}
