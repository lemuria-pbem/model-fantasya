<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Storage\Migration;

class Quest extends AbstractModel
{
	public function __construct() {
		$this->addInteger('id');
		$this->addInteger('owner');
		$this->addString('controller');
		$this->addArray('payload');
	}
}
