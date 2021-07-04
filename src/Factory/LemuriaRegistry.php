<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Factory;

use Lemuria\Assignable;
use Lemuria\Lemuria;
use Lemuria\Model\Catalog;
use Lemuria\Model\Fantasya\Party;
use Lemuria\Registry;

class LemuriaRegistry implements Registry
{
	protected ?array $parties = null;

	public function count(): int {
		$this->init();
		return count($this->parties);
	}

	public function find(string $uuid): ?Assignable {
		$this->init();
		return $this->parties[$uuid] ?? null;
	}

	protected function init(): void {
		if (!$this->parties) {
			$this->parties = [];
			foreach (Lemuria::Catalog()->getAll(Catalog::PARTIES) as $party /* @var Party $party */) {
				$this->parties[$party->Uuid()] = $party;
			}
		}
	}
}
