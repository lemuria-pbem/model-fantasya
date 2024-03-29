<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Storage\Migration;

use Lemuria\Model\Fantasya\Combat\BattleRow;

class Unit extends AbstractModel
{
	public function __construct() {
		$this->addInteger('id');
		$this->addString('name');
		$this->addString('description');
		$this->addString('race');
		$this->addInteger('size');
		$this->addInteger('aura', null);
		$this->addFloat('health', 1.0);
		$this->addBool('isGuarding');
		$this->addInteger('battleRow', BattleRow::Refugee->value);
		$this->addBool('isHiding');
		$this->addBool('isLooting', true);
		$this->addBool('isTransporting');
		$this->addBool('disguiseAs');
		$this->addArray('inventory');
		$this->addArray('treasury');
		$this->addArray('knowledge');
		$this->addArray('extensions');
	}
}
