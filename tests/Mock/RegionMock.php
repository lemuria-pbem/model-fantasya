<?php
declare(strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Mock;

use Lemuria\Id;
use Lemuria\Model\Fantasya\Region;

class RegionMock extends Region
{
	private Id $id;

	public function __construct(Id|int $id = 0) {
		parent::__construct();
		$this->id = is_int($id) ? new Id($id) : $id;
	}

	public function Id(): Id {
		return $this->id;
	}
}
