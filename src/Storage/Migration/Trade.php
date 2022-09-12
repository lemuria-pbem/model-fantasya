<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Storage\Migration;

class Trade extends AbstractModel
{
	public function __construct() {
		$this->addInteger('id');
		$this->addBool('isOffer');
		$this->addBool('isRepeat');
		$this->addString('goods');
		$this->addString('price');
	}
}
