<?php
declare(strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Mock;

use Lemuria\Id;
use Lemuria\Model\Fantasya\Region;
use Lemuria\Model\Fantasya\Unit;

class UnitMock extends Unit
{
	private Id $id;

	protected Region $region;

	public function __construct(Id|int $id = 0) {
		parent::__construct();
		$this->id = is_int($id) ? new Id($id) : $id;
	}

	public function Id(): Id {
		return $this->id;
	}

	public function Region(): Region {
		return $this->region;
	}

	public function setRegion(Region $region): UnitMock {
		$this->region = $region;
		return $this;
	}
}
