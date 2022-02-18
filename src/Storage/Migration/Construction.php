<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Storage\Migration;

class Construction extends AbstractModel
{
	public function __construct() {
		$this->addInteger('id');
		$this->addString('name');
		$this->addString('description');
		$this->addString('building');
		$this->addInteger('size');
		$this->addArray('inhabitants');
	}
}
