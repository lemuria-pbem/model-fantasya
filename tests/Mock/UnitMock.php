<?php
declare(strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Mock;

use Lemuria\Model\Fantasya\Region;
use Lemuria\Model\Fantasya\Unit;

class UnitMock extends Unit
{
	protected Region $region;

	public function Region(): Region {
		return $this->region;
	}

	public function setRegion(Region $region): UnitMock {
		$this->region = $region;
		return $this;
	}
}
