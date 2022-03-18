<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Storage\Migration;

class Vessel extends AbstractModel
{
	public function __construct() {
		$this->addInteger('id');
		$this->addString('name');
		$this->addString('description');
		$this->addString('anchor', null);
		$this->addInteger('port', null);
		$this->addString('ship');
		$this->addFloat('completion');
		$this->addArray('passengers');
		$this->addArray('treasury');
	}
}
