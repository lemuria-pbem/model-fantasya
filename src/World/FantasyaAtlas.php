<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\World;

use Lemuria\Model\Fantasya\Sorting\Region\ByResidents;
use Lemuria\Model\World\Atlas;
use Lemuria\Model\World\SortMode;

class FantasyaAtlas extends Atlas
{
	public function sort(SortMode $mode = SortMode::BY_ID): Atlas {
		switch ($mode) {
			case SortMode::BY_RESIDENTS :
				$this->sortUsing(new ByResidents());
				break;
			default :
				return parent::sort($mode);
		}
		return $this;
	}
}
