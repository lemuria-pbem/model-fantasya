<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Storage\Migration;

class Region extends AbstractModel
{
	public function __construct() {
		$this->addInteger('id');
		$this->addString('name');
		$this->addString('description');
		$this->addString('landscape');
		$this->addArray('roads', null);
		$this->addArray('herbage', null);
		$this->addArray('resources');
		$this->addArray('estate');
		$this->addArray('fleet');
		$this->addArray('residents');
		$this->addArray('luxuries', null);
		$this->addArray('treasury');
	}
}
