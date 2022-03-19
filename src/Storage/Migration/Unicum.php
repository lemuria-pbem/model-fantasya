<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Storage\Migration;

class Unicum extends AbstractModel
{
	public function __construct() {
		$this->addInteger('id');
		$this->addString('name');
		$this->addString('description');
		$this->addString('composition');
		$this->addArray('properties', null);
	}
}
