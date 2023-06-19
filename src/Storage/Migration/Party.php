<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Storage\Migration;

use Lemuria\Model\Fantasya\Party\Presettings;
use Lemuria\Model\Fantasya\Regulation;

class Party extends AbstractModel
{
	public function __construct() {
		$this->addInteger('id');
		$this->addString('name');
		$this->addString('description');
		$this->addInteger('type');
		$this->addString('banner');
		$this->addString('uuid');
		$this->addInteger('creation');
		$this->addInteger('round');
		$this->addInteger('retirement', null);
		$this->addInteger('origin');
		$this->addString('race');
		$this->addArray('diplomacy');
		$this->addArray('people');
		$this->addArray('chronicle');
		$this->addArray('herbalBook');
		$this->addArray('spellBook');
		$this->addArray('loot');
		$this->addSerializable('presettings', new Presettings());
		$this->addArray('possessions');
		$this->addSerializable('regulation', new Regulation());
	}
}
