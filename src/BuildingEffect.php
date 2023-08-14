<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use function Lemuria\getClass;

class BuildingEffect
{
	/**
	 * @var array<string, Modification>
	 */
	protected array $effects = [];

	public function add(Modification $modification): static {
		$talent = getClass($modification->Talent());
		$this->effects[$talent] = $modification;
		return $this;
	}

	public function getEffect(Talent $talent): ?Modification {
		$talent = getClass($talent);
		return $this->effects[$talent] ?? null;
	}
}
